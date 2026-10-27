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
| Scrapers met een volledige browser | Nee, niets helpt | Die voeren de JS uit en zien wat de bezoeker ziet. Deze scrapers zijn duur en zeldzaam voor e-mail-harvesting. |

### Vergelijking van de aanpakken

| Aanpak | Effectiviteit | Toegankelijkheid | Onderhoud |
|---|---|---|---|
| Server-side versleutelen, client-side decoderen | Hoog tegen niet-JS scrapers | Goed: na decoderen staat er gewone tekst en een gewone link | Laag: één filter en één script |
| Gesplitste strings die JS samenvoegt | Gemiddeld: de delen staan nog leesbaar in de bron | Goed na het samenvoegen | Hoog: elke plek moet handmatig gesplitst worden |
| CSS-trucs (omgekeerde tekst, verborgen spans) | Laag: DOM-tekst bevat het adres alsnog | Slecht: screenreaders lezen omgekeerde of extra tekst voor, en kopiëren geeft rommel | Gemiddeld |
| Pas tonen na klik/hover | Hoog | Slecht: een extra stap, en lastig met toetsenbord en op mobiel | Gemiddeld |

**Gekozen:** server-side versleutelen met XOR en een willekeurige sleutel per waarde, base64 als transport, decoderen met een klein inline script. Zonder JS ziet de bezoeker een leesbare fallback.

### SEO en structured data

- Structured data (JSON-LD in `<head>` en in `<script>`-tags) wordt **bewust niet** versleuteld. Google moet hetzelfde telefoonnummer en adres zien als in het Google Business Profile, en JSON-LD wordt niet door onze decoder verwerkt.
- Wel zijn het e-mailadres en telefoonnummer van **medewerkers** (schema `Person`) uit de structured data gehaald. Die leveren geen rich result op en zouden de obfuscatie volledig omzeilen. De bedrijfsgegevens (`Organization`, vestigingen) blijven staan.
- Meta-tags in `<head>` (description, Open Graph) worden niet aangepast, want daar draait geen JS. Zet daarom geen contactgegevens in de SEO-beschrijving van pagina's.

### Gedrag zonder JavaScript

- E-mail: `info [at] rondaan [punt] nl`
- Telefoon: `0518 · 462 · 070`
- WhatsApp-tekst: `WhatsApp`
- Links hebben geen `href` tot de JS draait. Ze zijn dan niet klikbaar, maar de tekst is wel leesbaar.

### Bekende beperkingen

- Adressen die al als HTML-entities in de bron staan, of telefoonnummers met `&nbsp;` ertussen, worden niet herkend.
- Telefoonnummers worden herkend als Nederlands formaat (`0` + 9 cijfers) of internationaal met een landcode van 2 cijfers (`+31`, `0031`, `+32`, `+49`). Andere formaten niet.
- Inhoud van `<script>`, `<style>`, `<textarea>` en HTML-comments wordt overgeslagen.
- Bij lange pagina's kan de bezoeker heel kort de fallback zien voordat het script draait.

## Hoe het werkt

1. `ContactObfuscationServiceProvider` start op `template_redirect` een output buffer voor alle front-end HTML (niet voor admin, feeds en de customizer).
2. `ContactObfuscator::protectHtml()` loopt door de HTML en:
   - vervangt `href="mailto:…"`, `tel:`, `sms:`, `whatsapp:`, `wa.me`, `api.whatsapp.com`, `signal.me` en `t.me` door `data-wfo-href="…"`;
   - vervangt e-mailadressen, telefoonnummers en `wa.me`-links in tekst door `<span class="wfo" data-wfo="…">fallback</span>`;
   - verplaatst `aria-label`, `title` en `alt` die contactgegevens bevatten naar `data-wfo-aria-label` enz.
3. `assets/js/contact-obfuscation.js` wordt inline in `wp_footer` gezet (met `nowprocket`, zodat WP Rocket hem niet uitstelt). Het script:
   - decodeert alles direct, en ook content die later wordt toegevoegd (AJAX, popups) via een `MutationObserver`;
   - vangt fouten per element af, zodat één kapotte waarde de rest niet blokkeert;
   - ondersteunt UTF-8 (`jöran@…`);
   - zorgt dat screenreaders het echte adres of nummer voorlezen. Een label als "E-mailadres" wordt aangevuld tot "E-mailadres: info@rondaan.nl".
   - opent WhatsApp-, Signal- en Telegram-links in een nieuw tabblad.

## Implementatie in bestaande projecten

Projecten op `wefabric/wp-theme` krijgen het automatisch na het updaten van de theme. Er hoeft niets gebouwd te worden: het script wordt inline geladen, niet via `app.js`.

Controleer na de update:

```bash
# Moet niets opleveren (JSON-LD en <head> uitgesloten)
curl -s https://example.nl/contact/ \
  | perl -0pe 's#<head\b.*?</head>##s; s#<script\b.*?</script>##gs' \
  | grep -oE '[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[a-z]{2,}|(mailto|tel):[^"]+|wa\.me/[^"]+|\b0[1-9]([ -]?[0-9]){8}\b'
```

Leeg de WP Rocket-cache na de update, anders wordt de oude HTML nog geserveerd.

### Uitschakelen

Voor een hele site, of voor specifieke pagina's:

```php
add_filter('wefabric/contact_obfuscation/enabled', fn () => ! is_page('contact'));
```

### Handmatig gebruiken

In templates is dit niet nodig, de output buffer pakt alles op. Wil je de functie gebruiken buiten de buffer (bijvoorbeeld in een e-mail-preview of REST-response die als HTML wordt getoond):

```blade
{!! \Theme\Helpers\ContactObfuscator::email('info@rondaan.nl') !!}
{!! \Theme\Helpers\ContactObfuscator::phone('0518 462 070') !!}
{!! \Theme\Helpers\ContactObfuscator::whatsapp('+31 6 12345678', 'Hallo!', 'Stuur een WhatsApp') !!}
```

Het decoder-script staat alleen op pagina's die `wp_footer` aanroepen.

### Laravel-projecten

De `ContactObfuscator`-klasse gebruikt alleen `esc_attr` en `esc_html` uit WordPress. Voor Laravel kun je die vervangen door `e()`, `protectHtml()` aanroepen in een middleware op HTML-responses, en het script in de layout opnemen. Een Blade-component als `<x-protected-email>` is dan een dunne wrapper rond `ContactObfuscator::email()`.
