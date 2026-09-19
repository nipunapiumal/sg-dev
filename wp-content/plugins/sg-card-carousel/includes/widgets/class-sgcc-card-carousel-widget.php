<?php
namespace SGCC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Card Carousel — a Swiper-powered carousel of media cards (image, badge
 * pills, title, subtitle, description, link).
 */
class Card_Carousel_Widget extends Widget_Base {

	public function get_name() {
		return 'sgcc-card-carousel';
	}

	public function get_title() {
		return esc_html__( 'Card Carousel', 'sg-card-carousel' );
	}

	public function get_icon() {
		return 'eicon-post-slider';
	}

	public function get_categories() {
		return [ 'sg-widgets' ];
	}

	public function get_keywords() {
		return [ 'carousel', 'slider', 'card', 'product', 'showcase', 'swiper' ];
	}

	public function get_style_depends() {
		return [ 'e-swiper', 'sgcc-card-carousel' ];
	}

	public function get_script_depends() {
		return [ 'swiper', 'sgcc-card-carousel' ];
	}

	protected function register_controls() {
		$this->register_content_controls();
		$this->register_settings_controls();
		$this->register_style_card_controls();
		$this->register_style_badge_controls();
		$this->register_style_text_controls();
		$this->register_style_overlay_controls();
		$this->register_style_navigation_controls();
	}

	/* ------------------------------------------------------------------ */
	/* Content                                                            */
	/* ------------------------------------------------------------------ */

	private function register_content_controls() {
		$this->start_controls_section(
			'section_cards',
			[
				'label' => esc_html__( 'Cards', 'sg-card-carousel' ),
			]
		);

		$this->add_control(
			'card_style',
			[
				'label'   => esc_html__( 'Card Style', 'sg-card-carousel' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => esc_html__( 'Media & Text', 'sg-card-carousel' ),
					'overlay' => esc_html__( 'Image Overlay', 'sg-card-carousel' ),
				],
			]
		);

		$this->add_control(
			'data_source',
			[
				'label'   => esc_html__( 'Card Source', 'sg-card-carousel' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'manual',
				'options' => [
					'manual' => esc_html__( 'Manual', 'sg-card-carousel' ),
					'posts'  => esc_html__( 'Posts (Dynamic)', 'sg-card-carousel' ),
				],
			]
		);

		$this->add_control(
			'description_limit',
			[
				'label'       => esc_html__( 'Description Character Limit', 'sg-card-carousel' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 120,
				'min'         => 0,
				'description' => esc_html__( 'Truncates the description on every card. Use 0 for no limit.', 'sg-card-carousel' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'card_image',
			[
				'label'   => esc_html__( 'Image', 'sg-card-carousel' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'card_title',
			[
				'label'       => esc_html__( 'Title', 'sg-card-carousel' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => esc_html__( 'Porsche 911', 'sg-card-carousel' ),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'card_flag',
			[
				'label'       => esc_html__( 'Flag / Emoji (Image Overlay style)', 'sg-card-carousel' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => false,
				'default'     => '',
				'placeholder' => '🇹🇷',
				'description' => esc_html__( 'Shown next to the title in the Image Overlay card style.', 'sg-card-carousel' ),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'card_subtitle',
			[
				'label'       => esc_html__( 'Subtitle', 'sg-card-carousel' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => esc_html__( 'GT3 RS', 'sg-card-carousel' ),
				'description' => esc_html__( 'In the Image Overlay style this renders as the stats line under the title (e.g. "1,991 Hotels • 42 Packages").', 'sg-card-carousel' ),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'card_description',
			[
				'label'       => esc_html__( 'Description', 'sg-card-carousel' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 3,
				'default'     => esc_html__( 'Timeless, iconic, and unapologetically analog — this embodies the soul of its finest era.', 'sg-card-carousel' ),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'heading_badges',
			[
				'label'     => esc_html__( 'Badges', 'sg-card-carousel' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		foreach ( [ 1, 2, 3 ] as $i ) {
			$defaults = [
				1 => [ 'icon' => 'fas fa-circle', 'text' => esc_html__( 'Ice grey', 'sg-card-carousel' ) ],
				2 => [ 'icon' => 'far fa-clock', 'text' => esc_html__( '3.2s', 'sg-card-carousel' ) ],
				3 => [ 'icon' => 'fas fa-cog', 'text' => esc_html__( 'Manual', 'sg-card-carousel' ) ],
			];

			$repeater->add_control(
				'badge_' . $i . '_icon',
				[
					'label'            => sprintf(
						/* translators: %d: badge number */
						esc_html__( 'Badge %d Icon', 'sg-card-carousel' ),
						$i
					),
					'type'             => Controls_Manager::ICONS,
					'skin'             => 'inline',
					'label_block'      => false,
					'default'          => [
						'value'   => $defaults[ $i ]['icon'],
						'library' => 0 === strpos( $defaults[ $i ]['icon'], 'far' ) ? 'fa-regular' : 'fa-solid',
					],
				]
			);

			$repeater->add_control(
				'badge_' . $i . '_text',
				[
					'label'       => sprintf(
						/* translators: %d: badge number */
						esc_html__( 'Badge %d Text', 'sg-card-carousel' ),
						$i
					),
					'type'        => Controls_Manager::TEXT,
					'label_block' => false,
					'default'     => $defaults[ $i ]['text'],
					'dynamic'     => [ 'active' => true ],
				]
			);
		}

		$repeater->add_control(
			'heading_link',
			[
				'label'     => esc_html__( 'Link', 'sg-card-carousel' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'card_link',
			[
				'label'       => esc_html__( 'Link', 'sg-card-carousel' ),
				'type'        => Controls_Manager::URL,
				'label_block' => true,
				'placeholder' => esc_html__( 'https://your-link.com', 'sg-card-carousel' ),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'card_button_text',
			[
				'label'       => esc_html__( 'Button / Link Text', 'sg-card-carousel' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => false,
				'default'     => esc_html__( 'Explore Now', 'sg-card-carousel' ),
				'description' => esc_html__( 'Shown as a button on the Image Overlay style, or a text link at the end of the Media & Text style. Leave empty to hide it.', 'sg-card-carousel' ),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'cards',
			[
				'label'       => esc_html__( 'Cards', 'sg-card-carousel' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'card_title'    => esc_html__( 'Porsche 911', 'sg-card-carousel' ),
						'card_subtitle' => esc_html__( 'GT3 RS', 'sg-card-carousel' ),
					],
					[
						'card_title'    => esc_html__( 'Porsche 718', 'sg-card-carousel' ),
						'card_subtitle' => esc_html__( 'Cayman GT4', 'sg-card-carousel' ),
					],
					[
						'card_title'    => esc_html__( 'Porsche Taycan', 'sg-card-carousel' ),
						'card_subtitle' => esc_html__( 'Turbo S', 'sg-card-carousel' ),
					],
				],
				'title_field' => '{{{ card_title }}} {{{ card_subtitle }}}',
				'condition'   => [ 'data_source' => 'manual' ],
			]
		);

		$this->add_control(
			'heading_posts_source',
			[
				'label'     => esc_html__( 'Posts Source', 'sg-card-carousel' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [ 'data_source' => 'posts' ],
			]
		);

		$this->add_control(
			'posts_post_type',
			[
				'label'       => esc_html__( 'Post Type', 'sg-card-carousel' ),
				'type'        => Controls_Manager::SELECT,
				'label_block' => true,
				'default'     => 'post',
				'options'     => $this->get_post_type_options(),
				'condition'   => [ 'data_source' => 'posts' ],
			]
		);

		$this->add_control(
			'posts_categories',
			[
				'label'       => esc_html__( 'Filter by Category', 'sg-card-carousel' ),
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'label_block' => true,
				'options'     => $this->get_all_category_options(),
				'description' => esc_html__( 'Terms from every category/taxonomy on the site — pick the ones that match the post type above. Leave empty to include everything of that post type.', 'sg-card-carousel' ),
				'condition'   => [ 'data_source' => 'posts' ],
			]
		);

		$this->add_control(
			'posts_specific',
			[
				'label'       => esc_html__( 'Select Specific Posts', 'sg-card-carousel' ),
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'label_block' => true,
				'options'     => $this->get_all_post_options(),
				'description' => esc_html__( 'Optional — hand-pick individual posts, of any post type, in addition to the category filter above.', 'sg-card-carousel' ),
				'condition'   => [ 'data_source' => 'posts' ],
			]
		);

		$this->add_control(
			'posts_count',
			[
				'label'       => esc_html__( 'Number of Posts', 'sg-card-carousel' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => -1,
				'description' => esc_html__( 'Maximum number of posts to show. Use -1 for no limit.', 'sg-card-carousel' ),
				'condition'   => [ 'data_source' => 'posts' ],
			]
		);

		$this->add_control(
			'posts_show_category',
			[
				'label'        => esc_html__( 'Show Category', 'sg-card-carousel' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
				'description'  => esc_html__( 'Displays each post\'s category/taxonomy term(s) as the card subtitle.', 'sg-card-carousel' ),
				'condition'    => [ 'data_source' => 'posts' ],
			]
		);

		$this->add_control(
			'posts_button_text',
			[
				'label'       => esc_html__( 'Button / Link Text', 'sg-card-carousel' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Learn More', 'sg-card-carousel' ),
				'description' => esc_html__( 'Shown as a button on the Image Overlay style, or a text link at the end of the Media & Text style. Leave empty to hide it.', 'sg-card-carousel' ),
				'condition'   => [ 'data_source' => 'posts' ],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'    => 'card_image',
				'default' => 'large',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Only worth building live DB-backed option lists when something is
	 * actually going to render them — Elementor strips 'options' from every
	 * control on plain frontend requests anyway (Performance::should_optimize_controls()).
	 */
	private function is_editor_context() {
		return ! \Elementor\Core\Frontend\Performance::should_optimize_controls();
	}

	/**
	 * Every public, browsable post type on the site (i.e. valid sources for
	 * the "Posts (Dynamic)" card source).
	 */
	private function get_post_type_options() {
		if ( ! $this->is_editor_context() ) {
			return [];
		}

		$post_types = get_post_types( [ 'public' => true, 'show_ui' => true ], 'objects' );
		unset( $post_types['attachment'], $post_types['elementor_library'] );

		$options = [];

		foreach ( $post_types as $post_type ) {
			$options[ $post_type->name ] = $post_type->labels->singular_name ? $post_type->labels->singular_name : $post_type->label;
		}

		return $options;
	}

	/**
	 * Every term from every public taxonomy on the site, labelled with its
	 * taxonomy so cards from any post type/category combination can be picked.
	 */
	private function get_all_category_options() {
		if ( ! $this->is_editor_context() ) {
			return [];
		}

		$taxonomies = get_taxonomies( [ 'public' => true ], 'objects' );
		$options    = [];

		foreach ( $taxonomies as $taxonomy ) {
			if ( 'post_format' === $taxonomy->name ) {
				continue;
			}

			$terms = get_terms( [
				'taxonomy'   => $taxonomy->name,
				'hide_empty' => false,
			] );

			if ( is_wp_error( $terms ) ) {
				continue;
			}

			foreach ( $terms as $term ) {
				$options[ $term->term_id ] = $term->name . ' (' . $taxonomy->label . ')';
			}
		}

		return $options;
	}

	/**
	 * Every published post across every public post type, labelled with its
	 * post type, for the "Select Specific Posts" control.
	 */
	private function get_all_post_options() {
		if ( ! $this->is_editor_context() ) {
			return [];
		}

		$post_types = array_keys( get_post_types( [ 'public' => true, 'show_ui' => true ], 'names' ) );
		$post_types = array_values( array_diff( $post_types, [ 'attachment', 'elementor_library' ] ) );

		if ( empty( $post_types ) ) {
			return [];
		}

		$posts = get_posts( [
			'post_type'      => $post_types,
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => 'title',
			'order'          => 'ASC',
		] );

		$options = [];

		foreach ( $posts as $post ) {
			$post_type_object = get_post_type_object( $post->post_type );
			$type_label        = $post_type_object ? $post_type_object->labels->singular_name : $post->post_type;
			$options[ $post->ID ] = $post->post_title . ' (' . $type_label . ')';
		}

		return $options;
	}

	/**
	 * All public taxonomy term names attached to a post, across whichever
	 * taxonomies its post type actually has — used as the card's subtitle.
	 */
	private function get_post_terms_label( $post_id, $post_type ) {
		$taxonomies = get_object_taxonomies( $post_type, 'names' );
		$names      = [];

		foreach ( $taxonomies as $taxonomy ) {
			if ( 'post_format' === $taxonomy ) {
				continue;
			}

			$taxonomy_object = get_taxonomy( $taxonomy );

			if ( ! $taxonomy_object || ! $taxonomy_object->public ) {
				continue;
			}

			$terms = get_the_terms( $post_id, $taxonomy );

			if ( $terms && ! is_wp_error( $terms ) ) {
				foreach ( $terms as $term ) {
					$names[] = $term->name;
				}
			}
		}

		return implode( ', ', array_unique( $names ) );
	}

	/**
	 * Build a repeater-shaped card array for each matching post, so
	 * render_card_default()/render_card_overlay() can be reused unchanged.
	 */
	private function get_dynamic_posts_cards( $settings ) {
		$post_type = ! empty( $settings['posts_post_type'] ) ? $settings['posts_post_type'] : 'post';

		if ( ! post_type_exists( $post_type ) ) {
			return [];
		}

		$category_ids = ! empty( $settings['posts_categories'] ) ? array_map( 'absint', (array) $settings['posts_categories'] ) : [];
		$post_ids     = ! empty( $settings['posts_specific'] ) ? array_map( 'absint', (array) $settings['posts_specific'] ) : [];
		$limit        = isset( $settings['posts_count'] ) ? (int) $settings['posts_count'] : -1;

		$base_args = [
			'post_type'      => $post_type,
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => 'menu_order date',
			'order'          => 'ASC',
			'fields'         => 'ids',
			'no_found_rows'  => true,
		];

		$found_ids = [];

		if ( $category_ids ) {
			// Group the selected terms by their own taxonomy — the same
			// multi-select can mix terms from any taxonomy on the site.
			$terms_by_taxonomy = [];

			foreach ( $category_ids as $term_id ) {
				$term = get_term( $term_id );

				if ( $term && ! is_wp_error( $term ) ) {
					$terms_by_taxonomy[ $term->taxonomy ][] = $term_id;
				}
			}

			if ( $terms_by_taxonomy ) {
				$tax_query = [ 'relation' => 'OR' ];

				foreach ( $terms_by_taxonomy as $taxonomy => $term_ids ) {
					$tax_query[] = [
						'taxonomy' => $taxonomy,
						'field'    => 'term_id',
						'terms'    => $term_ids,
					];
				}

				$found_ids = get_posts( array_merge( $base_args, [ 'tax_query' => $tax_query ] ) );
			}
		} elseif ( ! $post_ids ) {
			$found_ids = get_posts( $base_args );
		}

		if ( $post_ids ) {
			$found_ids = array_values( array_unique( array_merge( $found_ids, $post_ids ) ) );
		}

		if ( empty( $found_ids ) ) {
			return [];
		}

		if ( $limit > 0 ) {
			$found_ids = array_slice( $found_ids, 0, $limit );
		}

		$button_text   = ! empty( $settings['posts_button_text'] ) ? $settings['posts_button_text'] : '';
		$show_category = ! isset( $settings['posts_show_category'] ) || 'yes' === $settings['posts_show_category'];
		$cards         = [];

		foreach ( $found_ids as $post_id ) {
			$post = get_post( $post_id );

			if ( ! $post || 'publish' !== $post->post_status ) {
				continue;
			}

			$thumbnail_id = get_post_thumbnail_id( $post_id );

			$cards[] = [
				'_id'              => 'p' . $post_id,
				'card_image'       => $thumbnail_id ? [ 'id' => $thumbnail_id ] : [],
				'card_title'       => get_the_title( $post_id ),
				'card_flag'        => '',
				'card_subtitle'    => $show_category ? $this->get_post_terms_label( $post_id, $post->post_type ) : '',
				'card_description' => get_the_excerpt( $post_id ),
				'badge_1_text'     => '',
				'badge_2_text'     => '',
				'badge_3_text'     => '',
				'card_link'        => [
					'url'         => get_permalink( $post_id ),
					'is_external' => '',
					'nofollow'    => '',
				],
				'card_button_text' => $button_text,
			];
		}

		return $cards;
	}

	/* ------------------------------------------------------------------ */
	/* Carousel settings                                                  */
	/* ------------------------------------------------------------------ */

	private function register_settings_controls() {
		$this->start_controls_section(
			'section_carousel_settings',
			[
				'label' => esc_html__( 'Carousel Settings', 'sg-card-carousel' ),
			]
		);

		$slides = array_combine( range( 1, 6 ), range( 1, 6 ) );

		$this->add_responsive_control(
			'slides_to_show',
			[
				'label'           => esc_html__( 'Slides to Show', 'sg-card-carousel' ),
				'type'            => Controls_Manager::SELECT,
				'options'         => $slides,
				'default'         => 3,
				'tablet_default'  => 2,
				'mobile_default'  => 1,
				'frontend_available' => true,
			]
		);

		$this->add_responsive_control(
			'space_between',
			[
				'label'       => esc_html__( 'Space Between', 'sg-card-carousel' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px' ],
				'range'       => [
					'px' => [ 'max' => 100 ],
				],
				'default'     => [ 'size' => 24 ],
			]
		);

		$this->add_control(
			'navigation',
			[
				'label'   => esc_html__( 'Navigation', 'sg-card-carousel' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'both',
				'options' => [
					'both'   => esc_html__( 'Arrows and Dots', 'sg-card-carousel' ),
					'arrows' => esc_html__( 'Arrows', 'sg-card-carousel' ),
					'dots'   => esc_html__( 'Dots', 'sg-card-carousel' ),
					'none'   => esc_html__( 'None', 'sg-card-carousel' ),
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'loop',
			[
				'label'        => esc_html__( 'Infinite Loop', 'sg-card-carousel' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'        => esc_html__( 'Autoplay', 'sg-card-carousel' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'return_value' => 'yes',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label'   => esc_html__( 'Autoplay Speed (ms)', 'sg-card-carousel' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 5000,
				'condition' => [ 'autoplay' => 'yes' ],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'pause_on_hover',
			[
				'label'        => esc_html__( 'Pause on Hover', 'sg-card-carousel' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
				'condition'    => [ 'autoplay' => 'yes' ],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'speed',
			[
				'label'   => esc_html__( 'Transition Speed (ms)', 'sg-card-carousel' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 500,
				'frontend_available' => true,
			]
		);

		$this->end_controls_section();
	}

	/* ------------------------------------------------------------------ */
	/* Style — card                                                       */
	/* ------------------------------------------------------------------ */

	private function register_style_card_controls() {
		$this->start_controls_section(
			'section_style_card',
			[
				'label' => esc_html__( 'Card', 'sg-card-carousel' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'card_background',
			[
				'label'     => esc_html__( 'Background', 'sg-card-carousel' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .sgcc-card' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'card_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'sg-card-carousel' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => 24,
					'right'    => 24,
					'bottom'   => 24,
					'left'     => 24,
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .sgcc-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'card_box_shadow',
				'selector' => '{{WRAPPER}} .sgcc-card',
				'fields_options' => [
					'box_shadow_type' => [ 'default' => 'yes' ],
					'box_shadow' => [
						'default' => [
							'horizontal' => 0,
							'vertical'   => 12,
							'blur'       => 32,
							'spread'     => 0,
							'color'      => 'rgba(20, 20, 20, 0.12)',
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'card_padding',
			[
				'label'      => esc_html__( 'Content Padding', 'sg-card-carousel' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top'      => 20,
					'right'    => 20,
					'bottom'   => 24,
					'left'     => 20,
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .sgcc-card__body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [ 'card_style' => 'default' ],
			]
		);

		$this->add_responsive_control(
			'image_height',
			[
				'label'      => esc_html__( 'Image Height', 'sg-card-carousel' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh' ],
				'range'      => [
					'px' => [ 'min' => 100, 'max' => 600 ],
				],
				'default'    => [ 'size' => 280, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sgcc-card__media' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [ 'card_style' => 'default' ],
			]
		);

		$this->end_controls_section();
	}

	/* ------------------------------------------------------------------ */
	/* Style — badges                                                     */
	/* ------------------------------------------------------------------ */

	private function register_style_badge_controls() {
		$this->start_controls_section(
			'section_style_badges',
			[
				'label'     => esc_html__( 'Badges (Media & Text style)', 'sg-card-carousel' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'card_style' => 'default' ],
			]
		);

		$this->add_control(
			'badge_background',
			[
				'label'     => esc_html__( 'Background', 'sg-card-carousel' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#F3F4F6',
				'selectors' => [
					'{{WRAPPER}} .sgcc-badge' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'sg-card-carousel' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#4B5563',
				'selectors' => [
					'{{WRAPPER}} .sgcc-badge' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'sg-card-carousel' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#9CA3AF',
				'selectors' => [
					'{{WRAPPER}} .sgcc-badge i, {{WRAPPER}} .sgcc-badge svg' => 'color: {{VALUE}}; fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'badge_typography',
				'selector' => '{{WRAPPER}} .sgcc-badge',
			]
		);

		$this->add_responsive_control(
			'badge_gap',
			[
				'label'      => esc_html__( 'Gap Between Badges', 'sg-card-carousel' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'max' => 40 ] ],
				'default'    => [ 'size' => 8 ],
				'selectors'  => [
					'{{WRAPPER}} .sgcc-card__badges' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/* ------------------------------------------------------------------ */
	/* Style — title / subtitle / description                            */
	/* ------------------------------------------------------------------ */

	private function register_style_text_controls() {
		$this->start_controls_section(
			'section_style_text',
			[
				'label'     => esc_html__( 'Title & Description (Media & Text style)', 'sg-card-carousel' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'card_style' => 'default' ],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'sg-card-carousel' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#111827',
				'selectors' => [
					'{{WRAPPER}} .sgcc-card__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .sgcc-card__title',
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label'     => esc_html__( 'Subtitle Color', 'sg-card-carousel' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#9CA3AF',
				'selectors' => [
					'{{WRAPPER}} .sgcc-card__subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'subtitle_typography',
				'selector' => '{{WRAPPER}} .sgcc-card__subtitle',
			]
		);

		$this->add_control(
			'description_color',
			[
				'label'     => esc_html__( 'Description Color', 'sg-card-carousel' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#6B7280',
				'selectors' => [
					'{{WRAPPER}} .sgcc-card__desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .sgcc-card__desc',
			]
		);

		$this->add_control(
			'more_link_color',
			[
				'label'     => esc_html__( 'Button / Link Color', 'sg-card-carousel' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#111827',
				'selectors' => [
					'{{WRAPPER}} .sgcc-card__more' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'more_link_typography',
				'selector' => '{{WRAPPER}} .sgcc-card__more',
			]
		);

		$this->end_controls_section();
	}

	/* ------------------------------------------------------------------ */
	/* Style — image overlay                                              */
	/* ------------------------------------------------------------------ */

	private function register_style_overlay_controls() {
		$this->start_controls_section(
			'section_style_overlay',
			[
				'label'     => esc_html__( 'Image Overlay Style', 'sg-card-carousel' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'card_style' => 'overlay' ],
			]
		);

		$this->add_responsive_control(
			'overlay_min_height',
			[
				'label'      => esc_html__( 'Card Height', 'sg-card-carousel' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh' ],
				'range'      => [
					'px' => [ 'min' => 200, 'max' => 700 ],
				],
				'default'    => [ 'size' => 380, 'unit' => 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .sgcc-card--overlay' => 'min-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'overlay_gradient_color',
			[
				'label'     => esc_html__( 'Gradient Color', 'sg-card-carousel' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(10, 10, 10, 0.85)',
				'selectors' => [
					'{{WRAPPER}} .sgcc-card--overlay::before' => 'background-image: linear-gradient(180deg, rgba(0,0,0,0) 35%, {{VALUE}} 100%);',
				],
			]
		);

		$this->add_responsive_control(
			'overlay_content_padding',
			[
				'label'      => esc_html__( 'Content Padding', 'sg-card-carousel' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top'      => 20,
					'right'    => 20,
					'bottom'   => 20,
					'left'     => 20,
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .sgcc-card__overlay-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'heading_overlay_title',
			[
				'label'     => esc_html__( 'Title & Stats', 'sg-card-carousel' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'overlay_title_color',
			[
				'label'     => esc_html__( 'Title Color', 'sg-card-carousel' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .sgcc-card--overlay .sgcc-card__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'overlay_title_typography',
				'selector' => '{{WRAPPER}} .sgcc-card--overlay .sgcc-card__title',
			]
		);

		$this->add_control(
			'overlay_stats_color',
			[
				'label'     => esc_html__( 'Stats Color', 'sg-card-carousel' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255, 255, 255, 0.8)',
				'selectors' => [
					'{{WRAPPER}} .sgcc-card--overlay .sgcc-card__subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'overlay_stats_typography',
				'selector' => '{{WRAPPER}} .sgcc-card--overlay .sgcc-card__subtitle',
			]
		);

		$this->add_control(
			'heading_overlay_button',
			[
				'label'     => esc_html__( 'Button', 'sg-card-carousel' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'overlay_button_background',
			[
				'label'     => esc_html__( 'Background', 'sg-card-carousel' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255, 255, 255, 0.18)',
				'selectors' => [
					'{{WRAPPER}} .sgcc-card__button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'overlay_button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'sg-card-carousel' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .sgcc-card__button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/* ------------------------------------------------------------------ */
	/* Style — navigation                                                 */
	/* ------------------------------------------------------------------ */

	private function register_style_navigation_controls() {
		$this->start_controls_section(
			'section_style_navigation',
			[
				'label'     => esc_html__( 'Navigation', 'sg-card-carousel' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'navigation' => [ 'arrows', 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'heading_arrows',
			[
				'label'     => esc_html__( 'Arrows', 'sg-card-carousel' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [ 'navigation' => [ 'arrows', 'both' ] ],
			]
		);

		$this->add_control(
			'arrows_color',
			[
				'label'     => esc_html__( 'Color', 'sg-card-carousel' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#111827',
				'selectors' => [
					'{{WRAPPER}} .sgcc-nav' => 'color: {{VALUE}};',
				],
				'condition' => [ 'navigation' => [ 'arrows', 'both' ] ],
			]
		);

		$this->add_control(
			'arrows_background',
			[
				'label'     => esc_html__( 'Background', 'sg-card-carousel' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .sgcc-nav' => 'background-color: {{VALUE}};',
				],
				'condition' => [ 'navigation' => [ 'arrows', 'both' ] ],
			]
		);

		$this->add_control(
			'heading_dots',
			[
				'label'     => esc_html__( 'Dots', 'sg-card-carousel' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [ 'navigation' => [ 'dots', 'both' ] ],
			]
		);

		$this->add_control(
			'dots_color',
			[
				'label'     => esc_html__( 'Active Color', 'sg-card-carousel' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#111827',
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination-bullet-active' => 'background-color: {{VALUE}};',
				],
				'condition' => [ 'navigation' => [ 'dots', 'both' ] ],
			]
		);

		$this->add_control(
			'dots_inactive_color',
			[
				'label'     => esc_html__( 'Inactive Color', 'sg-card-carousel' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#D1D5DB',
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination-bullet' => 'background-color: {{VALUE}}; opacity: 1;',
				],
				'condition' => [ 'navigation' => [ 'dots', 'both' ] ],
			]
		);

		$this->end_controls_section();
	}

	/* ------------------------------------------------------------------ */
	/* Render                                                             */
	/* ------------------------------------------------------------------ */

	protected function render() {
		$settings = $this->get_settings_for_display();
		$cards    = 'posts' === $settings['data_source']
			? $this->get_dynamic_posts_cards( $settings )
			: $settings['cards'];

		if ( empty( $cards ) ) {
			if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
				echo '<div class="sgcc-empty-notice">' . esc_html__( 'No posts matched the current filters.', 'sg-card-carousel' ) . '</div>';
			}
			return;
		}

		$show_arrows = in_array( $settings['navigation'], [ 'arrows', 'both' ], true );
		$show_dots   = in_array( $settings['navigation'], [ 'dots', 'both' ], true );

		$config = [
			'slidesPerView'    => (int) ( $settings['slides_to_show'] ?: 3 ),
			'slidesPerViewTablet' => (int) ( $settings['slides_to_show_tablet'] ?: 2 ),
			'slidesPerViewMobile' => (int) ( $settings['slides_to_show_mobile'] ?: 1 ),
			'spaceBetween'     => (int) ( $settings['space_between']['size'] ?? 24 ),
			'spaceBetweenTablet' => isset( $settings['space_between_tablet']['size'] ) && '' !== $settings['space_between_tablet']['size'] ? (int) $settings['space_between_tablet']['size'] : null,
			'spaceBetweenMobile' => isset( $settings['space_between_mobile']['size'] ) && '' !== $settings['space_between_mobile']['size'] ? (int) $settings['space_between_mobile']['size'] : null,
			'loop'             => 'yes' === $settings['loop'],
			'autoplay'         => 'yes' === $settings['autoplay'] ? [
				'delay'                => (int) $settings['autoplay_speed'],
				'disableOnInteraction' => false,
				'pauseOnMouseEnter'    => 'yes' === $settings['pause_on_hover'],
			] : false,
			'speed'            => (int) $settings['speed'],
			'showArrows'       => $show_arrows,
			'showDots'         => $show_dots,
		];

		$is_overlay        = 'overlay' === $settings['card_style'];
		$description_limit = isset( $settings['description_limit'] ) ? (int) $settings['description_limit'] : 0;

		$this->add_render_attribute( 'swiper', 'class', 'sgcc-swiper swiper' );
		$this->add_render_attribute( 'swiper', 'data-sgcc-settings', wp_json_encode( $config ) );
		?>
		<div class="sgcc-carousel">
			<div <?php $this->print_render_attribute_string( 'swiper' ); ?>>
				<div class="swiper-wrapper">
					<?php foreach ( $cards as $card ) : ?>
						<div class="swiper-slide">
							<?php $is_overlay ? $this->render_card_overlay( $card ) : $this->render_card_default( $card, $description_limit ); ?>
						</div>
					<?php endforeach; ?>
				</div>

				<?php if ( count( $cards ) > 1 && $show_dots ) : ?>
					<div class="swiper-pagination sgcc-pagination"></div>
				<?php endif; ?>
			</div>

			<?php if ( count( $cards ) > 1 && $show_arrows ) : ?>
				<div class="sgcc-nav sgcc-nav--prev" role="button" tabindex="0" aria-label="<?php esc_attr_e( 'Previous', 'sg-card-carousel' ); ?>">
					<?php Icons_Manager::render_icon( [ 'library' => 'eicons', 'value' => 'eicon-chevron-left' ], [ 'aria-hidden' => 'true' ] ); ?>
				</div>
				<div class="sgcc-nav sgcc-nav--next" role="button" tabindex="0" aria-label="<?php esc_attr_e( 'Next', 'sg-card-carousel' ); ?>">
					<?php Icons_Manager::render_icon( [ 'library' => 'eicons', 'value' => 'eicon-chevron-right' ], [ 'aria-hidden' => 'true' ] ); ?>
				</div>
			<?php endif; ?>
		</div>
		<?php
	}

	private function get_card_image_url( $card ) {
		if ( ! empty( $card['card_image']['id'] ) ) {
			$image_size = $this->get_settings_for_display( 'card_image_size' );
			$src        = Group_Control_Image_Size::get_attachment_image_src( $card['card_image']['id'], 'card_image', $this->get_settings_for_display() );
			return $src ? $src : wp_get_attachment_image_url( $card['card_image']['id'], $image_size ? $image_size : 'large' );
		}

		return ! empty( $card['card_image']['url'] ) ? $card['card_image']['url'] : '';
	}

	private function render_card_default( $card, $description_limit = 0 ) {
		$has_link = ! empty( $card['card_link']['url'] );

		if ( $has_link ) {
			$link_key = 'card_link_' . $card['_id'];
			$this->add_link_attributes( $link_key, $card['card_link'] );
			echo '<a ' . $this->get_render_attribute_string( $link_key ) . ' class="sgcc-card">'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		} else {
			echo '<div class="sgcc-card">';
		}

		if ( ! empty( $card['card_image']['id'] ) ) {
			$image_size = $this->get_settings_for_display( 'card_image_size' );
			$image_html = wp_get_attachment_image( $card['card_image']['id'], $image_size ? $image_size : 'large', false, [ 'class' => 'sgcc-card__img', 'alt' => \Elementor\Control_Media::get_image_alt( $card['card_image'] ) ] );
		} elseif ( ! empty( $card['card_image']['url'] ) ) {
			$image_html = '<img class="sgcc-card__img" src="' . esc_url( $card['card_image']['url'] ) . '" alt="" />';
		} else {
			$image_html = '';
		}

		if ( $image_html ) {
			echo '<div class="sgcc-card__media">' . $image_html . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		echo '<div class="sgcc-card__body">';

		$badge_indexes = array_filter( [ 1, 2, 3 ], function ( $i ) use ( $card ) {
			return ! empty( $card[ 'badge_' . $i . '_text' ] );
		} );

		if ( ! empty( $badge_indexes ) ) {
			echo '<div class="sgcc-card__badges">';
			foreach ( $badge_indexes as $i ) {
				echo '<span class="sgcc-badge">';
				Icons_Manager::render_icon( $card[ 'badge_' . $i . '_icon' ], [ 'aria-hidden' => 'true' ] );
				echo '<span class="sgcc-badge__text">' . esc_html( $card[ 'badge_' . $i . '_text' ] ) . '</span>';
				echo '</span>';
			}
			echo '</div>';
		}

		if ( ! empty( $card['card_title'] ) || ! empty( $card['card_subtitle'] ) ) {
			echo '<h3 class="sgcc-card__title">';
			if ( ! empty( $card['card_title'] ) ) {
				echo esc_html( $card['card_title'] );
			}
			if ( ! empty( $card['card_subtitle'] ) ) {
				echo '<span class="sgcc-card__subtitle">' . esc_html( $card['card_subtitle'] ) . '</span>';
			}
			echo '</h3>';
		}

		if ( ! empty( $card['card_description'] ) ) {
			$description = $description_limit > 0 ? wp_html_excerpt( $card['card_description'], $description_limit, '…' ) : $card['card_description'];
			echo '<p class="sgcc-card__desc">' . esc_html( $description ) . '</p>';
		}

		if ( ! empty( $card['card_button_text'] ) ) {
			echo '<span class="sgcc-card__more">' . esc_html( $card['card_button_text'] ) . ' <i class="sgcc-card__more-arrow" aria-hidden="true">&rarr;</i></span>';
		}

		echo '</div>'; // .sgcc-card__body

		echo $has_link ? '</a>' : '</div>';
	}

	private function render_card_overlay( $card ) {
		$has_link   = ! empty( $card['card_link']['url'] );
		$image_url  = $this->get_card_image_url( $card );
		$card_class = 'sgcc-card sgcc-card--overlay';

		$style = $image_url ? ' style="background-image:url(' . esc_url( $image_url ) . ');"' : '';

		if ( $has_link ) {
			$link_key = 'card_link_' . $card['_id'];
			$this->add_link_attributes( $link_key, $card['card_link'] );
			echo '<a ' . $this->get_render_attribute_string( $link_key ) . ' class="' . esc_attr( $card_class ) . '"' . $style . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		} else {
			echo '<div class="' . esc_attr( $card_class ) . '"' . $style . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		echo '<div class="sgcc-card__overlay-content">';

		if ( ! empty( $card['card_title'] ) || ! empty( $card['card_flag'] ) || ! empty( $card['card_subtitle'] ) ) {
			echo '<div>';
			if ( ! empty( $card['card_title'] ) || ! empty( $card['card_flag'] ) ) {
				echo '<h3 class="sgcc-card__title">';
				if ( ! empty( $card['card_title'] ) ) {
					echo esc_html( $card['card_title'] );
				}
				if ( ! empty( $card['card_flag'] ) ) {
					echo ' <span class="sgcc-card__flag">' . esc_html( $card['card_flag'] ) . '</span>';
				}
				echo '</h3>';
			}
			if ( ! empty( $card['card_subtitle'] ) ) {
				echo '<span class="sgcc-card__subtitle">' . esc_html( $card['card_subtitle'] ) . '</span>';
			}
			echo '</div>';
		}

		if ( ! empty( $card['card_button_text'] ) ) {
			echo '<span class="sgcc-card__button">' . esc_html( $card['card_button_text'] ) . ' <i class="sgcc-card__button-arrow" aria-hidden="true">&rarr;</i></span>';
		}

		echo '</div>'; // .sgcc-card__overlay-content

		echo $has_link ? '</a>' : '</div>';
	}
}
