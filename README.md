Wefabric WordPress - Theme
==========================

# Pointers
A bit of developer insight in the blocks.

## Headers / Titles
Styling of the text is done in CSS. Only the placement in a block is done through tailwind classes on the HTML. This way a user can choose to select a H2 tag but use H4 styling (or vice versa) and the resulting code is simply: ```<h2 class="h4"> ... </h2>```.

- Styling is in: [assets/sass/_typography.scss](./assets/sass/_typography.scss)
- The title blocks are in: [views/components/headings/](./views/components/headings/)
  - Normal: is for one title
  - Collection: is for several titles below eachother (useful for e.g. a title and a subtitle.), and uses the `normal` block for each title.

