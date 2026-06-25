<?php
/**
 * Footer navigation menu helpers.
 *
 * @package Turnwell
 */

defined( 'ABSPATH' ) || exit;

/**
 * Build footer menu columns from the assigned Footer Menu location.
 *
 * Top-level items become column headings; their direct children become links.
 *
 * @return array<int, array{title: string, item: WP_Post, children: array<int, WP_Post>}>
 */
function turnwell_get_footer_menu_columns() {
	static $cached = null;

	if ( null !== $cached ) {
		return $cached;
	}

	$cached   = [];
	$locations = get_nav_menu_locations();

	if ( empty( $locations['footer'] ) ) {
		return $cached;
	}

	$menu_items = wp_get_nav_menu_items( (int) $locations['footer'] );

	if ( empty( $menu_items ) || ! is_array( $menu_items ) ) {
		return $cached;
	}

	$columns            = [];
	$children_by_parent = [];

	foreach ( $menu_items as $item ) {
		if ( ! $item instanceof WP_Post ) {
			continue;
		}

		$parent_id = (int) $item->menu_item_parent;

		if ( 0 === $parent_id ) {
			$columns[ (int) $item->ID ] = [
				'title'    => $item->title,
				'item'     => $item,
				'children' => [],
			];
		} else {
			$children_by_parent[ $parent_id ][] = $item;
		}
	}

	foreach ( $columns as $column_id => $column ) {
		if ( ! empty( $children_by_parent[ $column_id ] ) ) {
			$columns[ $column_id ]['children'] = $children_by_parent[ $column_id ];
		}
	}

	$cached = array_values( $columns );

	return $cached;
}

/**
 * Render footer navigation columns from the Footer Menu hierarchy.
 */
function turnwell_render_footer_menu() {
	$columns = turnwell_get_footer_menu_columns();

	if ( empty( $columns ) ) {
		return;
	}

	foreach ( $columns as $column ) {
		$item = $column['item'];
		?>
		<nav class="footer-col" aria-label="<?php echo esc_attr( $column['title'] ); ?>">
			<h3 class="footer-col-title"><?php echo esc_html( $column['title'] ); ?></h3>
			<?php if ( ! empty( $column['children'] ) ) : ?>
			<ul class="footer-links">
				<?php foreach ( $column['children'] as $child ) : ?>
				<li>
					<a href="<?php echo esc_url( $child->url ); ?>"<?php echo ! empty( $child->target ) ? ' target="' . esc_attr( $child->target ) . '"' : ''; ?><?php echo '_blank' === $child->target ? ' rel="noopener noreferrer"' : ''; ?>>
						<?php echo esc_html( $child->title ); ?>
					</a>
				</li>
				<?php endforeach; ?>
			</ul>
			<?php elseif ( ! empty( $item->url ) && '#' !== $item->url ) : ?>
			<ul class="footer-links">
				<li>
					<a href="<?php echo esc_url( $item->url ); ?>"<?php echo ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : ''; ?><?php echo '_blank' === $item->target ? ' rel="noopener noreferrer"' : ''; ?>>
						<?php echo esc_html( $column['title'] ); ?>
					</a>
				</li>
			</ul>
			<?php endif; ?>
		</nav>
		<?php
	}
}

/**
 * Create and assign the default footer menu if none exists.
 */
function turnwell_seed_footer_menu() {
	if ( get_option( 'turnwell_footer_menu_seeded' ) ) {
		return;
	}

	$locations = get_nav_menu_locations();

	if ( ! empty( $locations['footer'] ) ) {
		update_option( 'turnwell_footer_menu_seeded', 1 );

		return;
	}

	$menu_name = 'Footer Menu';
	$menu      = wp_get_nav_menu_object( $menu_name );

	if ( ! $menu ) {
		$menu_id = wp_create_nav_menu( $menu_name );

		if ( is_wp_error( $menu_id ) ) {
			return;
		}
	} else {
		$menu_id = (int) $menu->term_id;
	}

	$structure = [
		'Company' => [
			[
				'title' => 'About Turnwell',
				'url'   => home_url( '/about/' ),
			],
			[
				'title' => 'Leadership Team',
				'slug'  => 'our-team',
			],
			[
				'title' => 'News & Media',
				'slug'  => 'news',
			],
		],
		'Operations' => [
			[
				'title' => 'Execution Model',
				'slug'  => 'our-execution-model',
			],
			[
				'title' => 'Services',
				'slug'  => 'our-services',
			],
			[
				'title' => 'Technology',
				'slug'  => 'our-technology',
			],
		],
		'Contact' => [
			[
				'title' => 'Contact Us',
				'slug'  => 'contact-us',
			],
		],
	];

	foreach ( $structure as $parent_title => $children ) {
		$parent_id = wp_update_nav_menu_item(
			$menu_id,
			0,
			[
				'menu-item-title'  => $parent_title,
				'menu-item-url'    => '#',
				'menu-item-status' => 'publish',
				'menu-item-type'   => 'custom',
			]
		);

		if ( is_wp_error( $parent_id ) ) {
			continue;
		}

		foreach ( $children as $child ) {
			if ( ! empty( $child['slug'] ) ) {
				$page = get_page_by_path( $child['slug'] );

				if ( $page instanceof WP_Post ) {
					wp_update_nav_menu_item(
						$menu_id,
						0,
						[
							'menu-item-title'     => $child['title'],
							'menu-item-object'    => 'page',
							'menu-item-object-id' => $page->ID,
							'menu-item-type'      => 'post_type',
							'menu-item-status'    => 'publish',
							'menu-item-parent-id' => $parent_id,
						]
					);
					continue;
				}
			}

			if ( empty( $child['url'] ) ) {
				continue;
			}

			wp_update_nav_menu_item(
				$menu_id,
				0,
				[
					'menu-item-title'     => $child['title'],
					'menu-item-url'       => $child['url'],
					'menu-item-status'    => 'publish',
					'menu-item-type'      => 'custom',
					'menu-item-parent-id' => $parent_id,
				]
			);
		}
	}

	set_theme_mod( 'nav_menu_locations', array_merge( $locations, [ 'footer' => $menu_id ] ) );
	update_option( 'turnwell_footer_menu_seeded', 1 );
}
add_action( 'after_setup_theme', 'turnwell_seed_footer_menu', 20 );
