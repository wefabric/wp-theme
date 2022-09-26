Wefabric WordPress - Theme
==========================

# How to set me up
1. Correct the styling in [assets/sass/base/_typography.scss](assets/sass/base/_typography.scss) based on the sketch cheatsheet, and if neccessary add or change the font sizes in [tailwind.config.js](tailwind.config.js) to match.

# Pointers
A bit of developer insight in the blocks.

## Headers / Titles
Styling of the text is done in CSS. 
Only the placement in a block is done through tailwind classes on the HTML. 
This way a user can choose to select a H2 tag hierarchically but use H4 styling (or vice versa) and the resulting code is simply: ```<h2 class="h4 ..."> Heading </h2>```.

- Styling is defined in: [assets/sass/base/_typography.scss](./assets/sass/base/_typography.scss)
- Colors etc. are decided in: Wordpress (each block gets a text-color, bg-color, etc.).
- The title blocks are defined in: [views/components/headings/](./views/components/headings/)
  - Normal: is for one title
  - Collection: is for several titles below eachother (useful for e.g. a title and a subtitle.), and uses the `normal` block for each title.

