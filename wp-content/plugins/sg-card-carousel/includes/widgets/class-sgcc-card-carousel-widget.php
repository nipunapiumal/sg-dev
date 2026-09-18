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
				'label'       => esc_html__( 'Button Text (Image Overlay style)', 'sg-card-carousel' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => false,
				'default'     => esc_html__( 'Explore Now', 'sg-card-carousel' ),
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
		$cards    = $settings['cards'];

		if ( empty( $cards ) ) {
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

		$is_overlay = 'overlay' === $settings['card_style'];

		$this->add_render_attribute( 'swiper', 'class', 'sgcc-swiper swiper' );
		$this->add_render_attribute( 'swiper', 'data-sgcc-settings', wp_json_encode( $config ) );
		?>
		<div class="sgcc-carousel">
			<div <?php $this->print_render_attribute_string( 'swiper' ); ?>>
				<div class="swiper-wrapper">
					<?php foreach ( $cards as $card ) : ?>
						<div class="swiper-slide">
							<?php $is_overlay ? $this->render_card_overlay( $card ) : $this->render_card_default( $card ); ?>
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

	private function render_card_default( $card ) {
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
			echo '<p class="sgcc-card__desc">' . esc_html( $card['card_description'] ) . '</p>';
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
