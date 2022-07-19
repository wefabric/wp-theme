@include('components.blocks.usps-small', [
	'title' => $block->get('title'),
	'subtitle' => $block->get('subtitle'),
	'col_amount' => $block->get('col_amount'),
	'usps' => $block->get('usps'),
])