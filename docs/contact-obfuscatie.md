# Contact-obfuscatie

E-mailadressen, telefoonnummers en WhatsApp-, Signal- en Telegram-links worden versleuteld in de HTML gezet en pas in de browser weer leesbaar en klikbaar gemaakt. Dit gebeurt automatisch voor de hele pagina, ook voor content die redacteuren invoeren.

## Advies

### Wat scrapers nog doorzien

| Techniek | Effectief? | Waarom |
|---|---|---|
| HTML-entities (`&#64;`) | Nee | Elke HTML-parser decodeert entities. Ook WordPress' `antispambot()` werkt zo. |
| `[at]`/`[punt]`-vervanging | Beperkt | Gangbare scrapers herkennen dit patroon. Alleen geschikt als fallback zonder JS. |
| Kale base64 in data-attributen | Beperkt | Base64 van een adres is een herkenbaar patroon en is met één regel te decoderen. |
| Versleuteling met sleutel + JS-decoder | Ja | Scrapers zonder JavaScript zien alleen willekeurige bytes. Met een willekeurige sleutel per waarde is ook geen vaste payload te herkennen. |
| Cloudflare Email Obfuscation | Ja, maar alleen e-mail | Werkt alleen achter Cloudflare, doet niets met telefoon en WhatsApp, en laadt een extra script (`email-decode.min.js`) dat de laadtijd raakt. |
| Scrapers met een volledige browser | Nee, niets helpt | Die voeren de JS uit en zien wat de bezoeker ziet. Deze scrapers zijn duur en zeldzaam voor e-mail-harvesting. |

### Vergelijking van de aanpakken

| Aanpak | Effectiviteit | Toegankelijkheid | Onderhoud |
|---|---|---|---|
| Server-side versleutelen, client-side decoderen | Hoog tegen niet-JS scrapers | Goed: na decoderen staat er gewone tekst en een gewone link | Laag: één filter en één script |
| Gesplitste strings die JS samenvoegt | Gemiddeld: de delen staan nog leesbaar in de bron | Goed na het samenvoegen | Hoog: elke plek moet handmatig gesplitst worden |
| CSS-trucs (omgekeerde tekst, verborgen spans) | Laag: DOM-tekst bevat het adres alsnog | Slecht: screenreaders lezen omgekeerde of extra tekst voor, en kopiëren geeft rommel | Gemiddeld |
| Pas tonen na klik/hover | Hoog | Slecht: een extra stap, en lastig met toetsenbord en op mobiel | Gemiddeld |

**Gekozen:** server-side versleutelen met XOR en een willekeurige sleutel per waarde, base64 als transport, decoderen met een klein inline script. Zonder JS ziet de bezoeker een leesbare fallback.

De versleuteling draait als output buffer over de hele pagina, niet als filter op `the_content` en widgets. Contactgegevens staan ook in ACF-velden, blokken, de footer en menu's. Een filter op `the_content` mist die.

Er komt geen aparte plugin. De oplossing zit in `wefabric/wp-theme`, dus elke site op de parent theme krijgt het automatisch na een theme-update. Per site uitzetten kan met een filter (zie onder). Een plugin is pas nodig als er WordPress-sites zonder wp-theme bij komen. `ContactObfuscator` en de service provider gebruiken alleen WordPress-functies en kunnen dan zonder aanpassingen naar `wp-support`.

### SEO en structured data

- Structured data (JSON-LD in `<head>` en in `<script>`-tags) wordt **bewust niet** versleuteld. Google moet hetzelfde telefoonnummer en adres zien als in het Google Business Profile, en JSON-LD wordt niet door onze decoder verwerkt.
- **Afwijking van het acceptatiecriterium:** het telefoonnummer van het bedrijf blijft daardoor leesbaar in de ruwe HTML, in de `Organization`/`ContactPoint`-schema van Rank Math en de `LocalBusiness`-schema van het contactblok. Dat is een bewuste keuze voor SEO. Verder hoort er niets leesbaar in de HTML te staan.
- E-mailadressen staan **niet** in de structured data. Ze leveren geen rich result op en zouden de obfuscatie omzeilen. Dat geldt voor de vestigingen (`LocalBusiness` in het contactblok) en voor medewerkers (`Person`: geen e-mail, telefoon of WhatsApp-link).
- Rank Math kan zelf ook een e-mailadres in de `Organization`-schema zetten (Titels & Meta > Lokale SEO). Laat dat veld leeg.
- Meta-tags in `<head>` worden niet door de browser gedecodeerd. Daarom worden e-mailadressen, telefoonnummers en WhatsApp-links uit de Rank Math-`description`, `og:description` en `twitter:description` **verwijderd** in plaats van versleuteld, inclusief losse scheidingstekens (`verder. | 0518 … | info@…` wordt `verder.`). Zoekmachines tonen ze dan niet in de snippet. Zet ze daarom liever niet in de SEO-beschrijving, want de zin kan na het verwijderen stroef lopen ("Mail of bel voor info.").

### Gedrag zonder JavaScript

- E-mail: `info [at] example [punt] nl`
- Telefoon: `0123 · 456 · 789`
- WhatsApp-tekst: `WhatsApp`
- Links hebben geen `href` tot de JS draait. Ze zijn dan niet klikbaar, maar de tekst is wel leesbaar.

### Bekende beperkingen

- Adressen die al als HTML-entities in de bron staan, of telefoonnummers met `&nbsp;` ertussen, worden niet herkend.
- Telefoonnummers worden herkend als Nederlands formaat (`0` + 9 cijfers) of internationaal met een landcode van 2 cijfers (`+31`, `0031`, `+32`, `+49`). Andere formaten niet.
- Inhoud van `<script>`, `<style>`, `<textarea>`, `<option>` en HTML-comments wordt overgeslagen.
- Alleen `href`, `aria-label`, `title` en `alt` worden versleuteld. Contactgegevens in andere attributen, zoals `<input value="…">`, `placeholder` of `data-*`, blijven leesbaar.
- Bij lange pagina's kan de bezoeker heel kort de fallback zien voordat het script draait.

## Hoe het werkt

1. `ContactObfuscationServiceProvider` start op `template_redirect` een output buffer voor alle front-end HTML (niet voor admin, feeds en de customizer).
2. `ContactObfuscator::protectHtml()` loopt door de HTML en:
   - vervangt `href="mailto:…"`, `tel:`, `whatsapp:`, `wa.me`, `api.whatsapp.com`, `signal.me` en `t.me` door `data-wfo-href="…"`;
   - vervangt e-mailadressen, telefoonnummers en `wa.me`-links in tekst door `<span class="wfo" data-wfo="…">fallback</span>`;
   - verplaatst `aria-label`, `title` en `alt` die contactgegevens bevatten naar `data-wfo-aria-label` enz.
3. `assets/js/contact-obfuscation.js` wordt inline in `wp_footer` gezet (met `nowprocket`, zodat WP Rocket hem niet uitstelt). Het script:
   - decodeert alles direct, en ook content die later wordt toegevoegd (AJAX, popups) via een `MutationObserver`;
   - vangt fouten per element af, zodat één kapotte waarde de rest niet blokkeert;
   - ondersteunt UTF-8 (`jöran@…`);
   - zorgt dat screenreaders het echte adres of nummer voorlezen. Een label als "E-mailadres" wordt aangevuld tot "E-mailadres: info@example.nl".

## Implementatie in bestaande projecten

Projecten op `wefabric/wp-theme` krijgen het automatisch na het updaten van de theme. Er hoeft niets gebouwd te worden: het script wordt inline geladen, niet via `app.js`.

Controleer na de update:

```bash
# Doorzoekt de volledige HTML, inclusief <head> en JSON-LD
curl -s https://example.nl/contact/ \
  | grep -oE '.{40}([A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[a-z]{2,}|(mailto|tel):[^"]+|wa\.me/[^"]+|\b0[1-9]([ -]?[0-9]){8}\b|\+31[ 0-9]{9,13})'
```

Het enige toegestane resultaat is het telefoonnummer van het bedrijf in de JSON-LD (`"telephone":…`). Komt er iets anders uit, zoals een e-mailadres in de JSON-LD of een nummer in een meta-tag die niet van Rank Math komt, pas dan de Rank Math-instellingen of die plugin aan.

Leeg de WP Rocket-cache na de update, anders wordt de oude HTML nog geserveerd.

### Uitschakelen

Voor een hele site, of voor specifieke pagina's:

```php
add_filter('wefabric/contact_obfuscation/enabled', fn () => ! is_page('contact'));
```

### Handmatig gebruiken

In templates is dit niet nodig, de output buffer pakt alles op. Wil je contactgegevens toch expliciet beschermd uitleveren, gebruik dan de Blade-componenten:

```blade
<x-protected-email email="info@example.nl" />
<x-protected-phone phone="0123 456 789" label="Bel ons" class="btn" />
<x-protected-whatsapp number="+31 6 12345678" message="Hallo!" label="Stuur een WhatsApp" />
```

Of de helper:

```blade
{!! \Theme\Helpers\ContactObfuscator::email('info@example.nl') !!}
{!! \Theme\Helpers\ContactObfuscator::phone('0123 456 789') !!}
{!! \Theme\Helpers\ContactObfuscator::whatsapp('+31 6 12345678', 'Hallo!', 'Stuur een WhatsApp') !!}
```

Het decoder-script staat alleen op pagina's die `wp_footer` aanroepen. Gebruik de componenten dus niet in HTML zonder `wp_footer`, zoals een REST-response. Staat de obfuscatie uit via het filter, dan geven de componenten een gewone link.

### Laravel-projecten

Buiten scope van deze oplevering: er is nog geen Laravel-package. De aanpak is wel direct over te zetten. De `ContactObfuscator`-klasse gebruikt WordPress alleen voor escapen (`esc_attr`, `esc_html`, `esc_url`) en voor de aan/uit-check in `isEnabled()`. Voor Laravel vervang je die door `e()` en een config-waarde, roep je `protectHtml()` aan in een middleware op HTML-responses, en neem je het script op in de layout. De Blade-componenten `<x-protected-email>`, `<x-protected-phone>` en `<x-protected-whatsapp>` uit `views/components` kunnen zo mee.
