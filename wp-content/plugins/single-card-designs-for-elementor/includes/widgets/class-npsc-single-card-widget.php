<?php
namespace NPSC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Single Card — a product/content showcase card with two selectable
 * templates (Light and Image Overlay), fully customizable text, fonts,
 * image, height, and button styling.
 */
class Single_Card_Widget extends Widget_Base {

	public function get_name() {
		return 'npsc-single-card';
	}

	public function get_title() {
		return esc_html__( 'Single Card', 'single-card-designs-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-post-navigation';
	}

	public function get_categories() {
		return [ 'np-widgets' ];
	}

	public function get_keywords() {
		return [ 'card', 'product', 'showcase', 'book', 'single card' ];
	}

	public function get_style_depends() {
		return [ 'npsc-single-card' ];
	}

	protected function register_controls() {
		$this->register_content_controls();
		$this->register_style_card_controls();
		$this->register_style_image_controls();
		$this->register_style_tags_rating_controls();
		$this->register_style_title_badge_controls();
		$this->register_style_description_controls();
		$this->register_style_author_controls();
		$this->register_style_button_controls();
		$this->register_style_dots_controls();
	}

	/* ------------------------------------------------------------------ */
	/* Content                                                            */
	/* ------------------------------------------------------------------ */

	private function register_content_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Card', 'single-card-designs-for-elementor' ),
			]
		);

		$this->add_control(
			'template',
			[
				'label'   => esc_html__( 'Template', 'single-card-designs-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'template_1',
				'options' => [
					'template_1' => esc_html__( 'Template 1 — Light', 'single-card-designs-for-elementor' ),
					'template_2' => esc_html__( 'Template 2 — Image Overlay', 'single-card-designs-for-elementor' ),
				],
			]
		);

		$this->add_control(
			'card_image',
			[
				'label'   => esc_html__( 'Image', 'single-card-designs-for-elementor' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [ 'url' => Utils::get_placeholder_image_src() ],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'    => 'card_image',
				'default' => 'medium_large',
			]
		);

		$this->add_control(
			'heading_tags',
			[
				'label'     => esc_html__( 'Tags', 'single-card-designs-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$tags_repeater = new Repeater();

		$tags_repeater->add_control(
			'tag_text',
			[
				'label'       => esc_html__( 'Tag', 'single-card-designs-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => false,
				'default'     => esc_html__( 'Tag', 'single-card-designs-for-elementor' ),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'tags',
			[
				'label'       => esc_html__( 'Tags', 'single-card-designs-for-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $tags_repeater->get_controls(),
				'default'     => [
					[ 'tag_text' => esc_html__( 'Adventures', 'single-card-designs-for-elementor' ) ],
					[ 'tag_text' => esc_html__( 'Ancient', 'single-card-designs-for-elementor' ) ],
				],
				'title_field' => '{{{ tag_text }}}',
			]
		);

		$this->add_control(
			'heading_rating',
			[
				'label'     => esc_html__( 'Rating', 'single-card-designs-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'show_rating',
			[
				'label'        => esc_html__( 'Show Rating', 'single-card-designs-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'rating_icon',
			[
				'label'     => esc_html__( 'Rating Icon', 'single-card-designs-for-elementor' ),
				'type'      => Controls_Manager::ICONS,
				'skin'      => 'inline',
				'default'   => [ 'value' => 'fas fa-star', 'library' => 'fa-solid' ],
				'condition' => [ 'show_rating' => 'yes' ],
			]
		);

		$this->add_control(
			'rating_value',
			[
				'label'       => esc_html__( 'Rating Value', 'single-card-designs-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => false,
				'default'     => '4.8',
				'dynamic'     => [ 'active' => true ],
				'condition'   => [ 'show_rating' => 'yes' ],
			]
		);

		$this->add_control(
			'heading_title',
			[
				'label'     => esc_html__( 'Title & Badge', 'single-card-designs-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'single-card-designs-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => esc_html__( 'Safari Adventure', 'single-card-designs-for-elementor' ),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'highlight_badge',
			[
				'label'       => esc_html__( 'Highlight Badge', 'single-card-designs-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => false,
				'default'     => esc_html__( 'Top Rated', 'single-card-designs-for-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'description' => esc_html__( 'Leave empty to hide.', 'single-card-designs-for-elementor' ),
			]
		);

		$this->add_control(
			'heading_description',
			[
				'label'     => esc_html__( 'Description', 'single-card-designs-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'show_description',
			[
				'label'        => esc_html__( 'Show Description', 'single-card-designs-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'description',
			[
				'label'       => esc_html__( 'Description', 'single-card-designs-for-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 4,
				'maxlength'   => 500,
				'default'     => esc_html__( "One of Willard Price's adventure stories featuring Hal and Roger Hunt. The boys have a new quarry - the big-game poachers ...", 'single-card-designs-for-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'description' => esc_html__( '500 characters maximum. Shown truncated at 120 characters with a "See More" toggle if longer.', 'single-card-designs-for-elementor' ),
				'condition'   => [ 'show_description' => 'yes' ],
			]
		);

		$this->add_control(
			'heading_author',
			[
				'label'     => esc_html__( 'Author / Brand', 'single-card-designs-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'author_text',
			[
				'label'       => esc_html__( 'Author / Brand Text', 'single-card-designs-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => false,
				'default'     => esc_html__( 'Red Fox', 'single-card-designs-for-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'description' => esc_html__( 'Leave empty to hide.', 'single-card-designs-for-elementor' ),
			]
		);

		$this->add_control(
			'heading_button',
			[
				'label'     => esc_html__( 'Button', 'single-card-designs-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'show_button',
			[
				'label'        => esc_html__( 'Show Button', 'single-card-designs-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'       => esc_html__( 'Button Text', 'single-card-designs-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => false,
				'default'     => esc_html__( 'Buy this Book', 'single-card-designs-for-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'condition'   => [ 'show_button' => 'yes' ],
			]
		);

		$this->add_control(
			'button_link',
			[
				'label'       => esc_html__( 'Button Link', 'single-card-designs-for-elementor' ),
				'type'        => Controls_Manager::URL,
				'label_block' => true,
				'placeholder' => esc_html__( 'https://your-link.com', 'single-card-designs-for-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'condition'   => [ 'show_button' => 'yes' ],
			]
		);

		$this->add_control(
			'heading_dots',
			[
				'label'     => esc_html__( 'Image Dots (decorative)', 'single-card-designs-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'show_dots',
			[
				'label'        => esc_html__( 'Show Dots', 'single-card-designs-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
				'description'  => esc_html__( 'Purely decorative gallery-style dots overlaid on the image.', 'single-card-designs-for-elementor' ),
			]
		);

		$this->add_control(
			'dots_count',
			[
				'label'     => esc_html__( 'Number of Dots', 'single-card-designs-for-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 4,
				'min'       => 1,
				'max'       => 10,
				'condition' => [ 'show_dots' => 'yes' ],
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
				'label' => esc_html__( 'Card', 'single-card-designs-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'card_background',
			[
				'label'     => esc_html__( 'Background', 'single-card-designs-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .npsc-card' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'card_height',
			[
				'label'      => esc_html__( 'Card Height', 'single-card-designs-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 200, 'max' => 900 ] ],
				'default'         => [ 'unit' => 'px', 'size' => 560 ],
				'tablet_default'  => [ 'unit' => 'px', 'size' => 520 ],
				'mobile_default'  => [ 'unit' => 'px', 'size' => 480 ],
				'selectors'  => [
					'{{WRAPPER}} .npsc-card' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'card_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'single-card-designs-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => 20, 'right' => 20, 'bottom' => 20, 'left' => 20, 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .npsc-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'card_box_shadow',
				'selector' => '{{WRAPPER}} .npsc-card',
			]
		);

		$this->add_responsive_control(
			'card_body_padding',
			[
				'label'      => esc_html__( 'Content Padding', 'single-card-designs-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [ 'top' => 20, 'right' => 20, 'bottom' => 20, 'left' => 20, 'unit' => 'px', 'isLinked' => false ],
				'selectors'  => [
					'{{WRAPPER}} .npsc-card__body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/* ------------------------------------------------------------------ */
	/* Style — image / overlay                                            */
	/* ------------------------------------------------------------------ */

	private function register_style_image_controls() {
		$this->start_controls_section(
			'section_style_image',
			[
				'label' => esc_html__( 'Image', 'single-card-designs-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'image_height',
			[
				'label'      => esc_html__( 'Image Height', 'single-card-designs-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [ 'min' => 80, 'max' => 700 ],
					'%'  => [ 'min' => 10, 'max' => 100 ],
				],
				'default'    => [ 'unit' => '%', 'size' => 55 ],
				'selectors'  => [
					'{{WRAPPER}} .npsc-card--light .npsc-card__media' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [ 'template' => 'template_1' ],
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label'      => esc_html__( 'Image Border Radius', 'single-card-designs-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => 16, 'right' => 16, 'bottom' => 0, 'left' => 16, 'unit' => 'px', 'isLinked' => false ],
				'selectors'  => [
					'{{WRAPPER}} .npsc-card--light .npsc-card__media' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				],
				'condition'  => [ 'template' => 'template_1' ],
			]
		);

		$this->add_control(
			'heading_gradient',
			[
				'label'     => esc_html__( 'Overlay Gradient', 'single-card-designs-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [ 'template' => 'template_2' ],
			]
		);

		$this->add_control(
			'gradient_color',
			[
				'label'     => esc_html__( 'Gradient Color', 'single-card-designs-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(0,0,0,0.9)',
				'selectors' => [
					'{{WRAPPER}} .npsc-card__gradient' => 'background-image: linear-gradient(180deg, rgba(0,0,0,0) 30%, {{VALUE}} 100%);',
				],
				'condition' => [ 'template' => 'template_2' ],
			]
		);

		$this->end_controls_section();
	}

	/* ------------------------------------------------------------------ */
	/* Style — tags & rating                                              */
	/* ------------------------------------------------------------------ */

	private function register_style_tags_rating_controls() {
		$this->start_controls_section(
			'section_style_tags_rating',
			[
				'label' => esc_html__( 'Tags & Rating', 'single-card-designs-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_tags_style',
			[
				'label' => esc_html__( 'Tags', 'single-card-designs-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'tag_background',
			[
				'label'     => esc_html__( 'Background', 'single-card-designs-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(0,0,0,0.45)',
				'selectors' => [
					'{{WRAPPER}} .npsc-tag' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tag_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'single-card-designs-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .npsc-tag' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'tag_typography',
				'selector' => '{{WRAPPER}} .npsc-tag',
			]
		);

		$this->add_control(
			'heading_rating_style',
			[
				'label'     => esc_html__( 'Rating Badge', 'single-card-designs-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'rating_background',
			[
				'label'     => esc_html__( 'Background', 'single-card-designs-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(0,0,0,0.45)',
				'selectors' => [
					'{{WRAPPER}} .npsc-card__rating' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'rating_text_color',
			[
				'label'     => esc_html__( 'Text & Icon Color', 'single-card-designs-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .npsc-card__rating' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'rating_typography',
				'selector' => '{{WRAPPER}} .npsc-card__rating',
			]
		);

		$this->end_controls_section();
	}

	/* ------------------------------------------------------------------ */
	/* Style — title & badge                                              */
	/* ------------------------------------------------------------------ */

	private function register_style_title_badge_controls() {
		$this->start_controls_section(
			'section_style_title_badge',
			[
				'label' => esc_html__( 'Title & Badge', 'single-card-designs-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'single-card-designs-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#111827',
				'selectors' => [
					'{{WRAPPER}} .npsc-card__title' => 'color: {{VALUE}};',
				],
				'condition' => [ 'template' => 'template_1' ],
			]
		);

		$this->add_control(
			'title_color_overlay',
			[
				'label'     => esc_html__( 'Title Color', 'single-card-designs-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .npsc-card__title' => 'color: {{VALUE}};',
				],
				'condition' => [ 'template' => 'template_2' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .npsc-card__title',
				'fields_options' => [
					'font_size'   => [ 'default' => [ 'unit' => 'px', 'size' => 22 ] ],
					'font_weight' => [ 'default' => '700' ],
				],
			]
		);

		$this->add_control(
			'heading_badge_style',
			[
				'label'     => esc_html__( 'Highlight Badge', 'single-card-designs-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'badge_background',
			[
				'label'     => esc_html__( 'Background', 'single-card-designs-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'transparent',
				'selectors' => [
					'{{WRAPPER}} .npsc-card__highlight' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_text_color',
			[
				'label'     => esc_html__( 'Text & Border Color', 'single-card-designs-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#111827',
				'selectors' => [
					'{{WRAPPER}} .npsc-card__highlight' => 'color: {{VALUE}}; border-color: {{VALUE}};',
				],
				'condition' => [ 'template' => 'template_1' ],
			]
		);

		$this->add_control(
			'badge_text_color_overlay',
			[
				'label'     => esc_html__( 'Text & Border Color', 'single-card-designs-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .npsc-card__highlight' => 'color: {{VALUE}}; border-color: {{VALUE}};',
				],
				'condition' => [ 'template' => 'template_2' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'badge_typography',
				'selector' => '{{WRAPPER}} .npsc-card__highlight',
			]
		);

		$this->end_controls_section();
	}

	/* ------------------------------------------------------------------ */
	/* Style — description                                                */
	/* ------------------------------------------------------------------ */

	private function register_style_description_controls() {
		$this->start_controls_section(
			'section_style_description',
			[
				'label' => esc_html__( 'Description', 'single-card-designs-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'description_color',
			[
				'label'     => esc_html__( 'Color', 'single-card-designs-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#6B7280',
				'selectors' => [
					'{{WRAPPER}} .npsc-card__desc, {{WRAPPER}} .npsc-card__desc-toggle-label' => 'color: {{VALUE}};',
				],
				'condition' => [ 'template' => 'template_1' ],
			]
		);

		$this->add_control(
			'description_color_overlay',
			[
				'label'     => esc_html__( 'Color', 'single-card-designs-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255,255,255,0.85)',
				'selectors' => [
					'{{WRAPPER}} .npsc-card__desc, {{WRAPPER}} .npsc-card__desc-toggle-label' => 'color: {{VALUE}};',
				],
				'condition' => [ 'template' => 'template_2' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .npsc-card__desc',
			]
		);

		$this->end_controls_section();
	}

	/* ------------------------------------------------------------------ */
	/* Style — author                                                     */
	/* ------------------------------------------------------------------ */

	private function register_style_author_controls() {
		$this->start_controls_section(
			'section_style_author',
			[
				'label' => esc_html__( 'Author / Brand', 'single-card-designs-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'author_color',
			[
				'label'     => esc_html__( 'Color', 'single-card-designs-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#111827',
				'selectors' => [
					'{{WRAPPER}} .npsc-card__author' => 'color: {{VALUE}};',
				],
				'condition' => [ 'template' => 'template_1' ],
			]
		);

		$this->add_control(
			'author_color_overlay',
			[
				'label'     => esc_html__( 'Color', 'single-card-designs-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .npsc-card__author' => 'color: {{VALUE}};',
				],
				'condition' => [ 'template' => 'template_2' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'author_typography',
				'selector' => '{{WRAPPER}} .npsc-card__author',
				'fields_options' => [
					'font_weight' => [ 'default' => '700' ],
				],
			]
		);

		$this->end_controls_section();
	}

	/* ------------------------------------------------------------------ */
	/* Style — button                                                     */
	/* ------------------------------------------------------------------ */

	private function register_style_button_controls() {
		$this->start_controls_section(
			'section_style_button',
			[
				'label' => esc_html__( 'Button', 'single-card-designs-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'button_style_tabs' );

		$this->start_controls_tab(
			'button_style_normal',
			[ 'label' => esc_html__( 'Normal', 'single-card-designs-for-elementor' ) ]
		);

		$this->add_control(
			'button_background',
			[
				'label'     => esc_html__( 'Background', 'single-card-designs-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#111827',
				'selectors' => [
					'{{WRAPPER}} .npsc-card__button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'single-card-designs-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .npsc-card__button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'button_style_hover',
			[ 'label' => esc_html__( 'Hover', 'single-card-designs-for-elementor' ) ]
		);

		$this->add_control(
			'button_background_hover',
			[
				'label'     => esc_html__( 'Background', 'single-card-designs-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2d3748',
				'selectors' => [
					'{{WRAPPER}} .npsc-card__button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_text_color_hover',
			[
				'label'     => esc_html__( 'Text Color', 'single-card-designs-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .npsc-card__button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} .npsc-card__button',
				'fields_options' => [
					'font_weight' => [ 'default' => '600' ],
				],
			]
		);

		$this->add_responsive_control(
			'button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'single-card-designs-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => 12, 'right' => 12, 'bottom' => 12, 'left' => 12, 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .npsc-card__button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Padding', 'single-card-designs-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [ 'top' => 14, 'right' => 20, 'bottom' => 14, 'left' => 20, 'unit' => 'px', 'isLinked' => false ],
				'selectors'  => [
					'{{WRAPPER}} .npsc-card__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/* ------------------------------------------------------------------ */
	/* Style — dots                                                       */
	/* ------------------------------------------------------------------ */

	private function register_style_dots_controls() {
		$this->start_controls_section(
			'section_style_dots',
			[
				'label'     => esc_html__( 'Image Dots', 'single-card-designs-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_dots' => 'yes' ],
			]
		);

		$this->add_control(
			'dots_color',
			[
				'label'     => esc_html__( 'Dot Color', 'single-card-designs-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255,255,255,0.5)',
				'selectors' => [
					'{{WRAPPER}} .npsc-dot' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'dots_active_color',
			[
				'label'     => esc_html__( 'Active Dot Color', 'single-card-designs-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .npsc-dot.npsc-dot--active' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/* ------------------------------------------------------------------ */
	/* Render                                                             */
	/* ------------------------------------------------------------------ */

	private function get_image_url( $settings ) {
		if ( ! empty( $settings['card_image']['id'] ) ) {
			$src = Group_Control_Image_Size::get_attachment_image_src( $settings['card_image']['id'], 'card_image', $settings );
			return $src ? $src : wp_get_attachment_image_url( $settings['card_image']['id'], 'large' );
		}

		return ! empty( $settings['card_image']['url'] ) ? $settings['card_image']['url'] : '';
	}

	private function render_dots( $settings ) {
		if ( 'yes' !== $settings['show_dots'] ) {
			return;
		}

		$count = max( 1, (int) $settings['dots_count'] );
		echo '<div class="npsc-card__dots">';
		for ( $i = 0; $i < $count; $i++ ) {
			$class = 0 === $i ? 'npsc-dot npsc-dot--active' : 'npsc-dot';
			echo '<span class="' . esc_attr( $class ) . '"></span>';
		}
		echo '</div>';
	}

	private function render_tags_and_rating( $settings ) {
		echo '<div class="npsc-card__top-row">';

		if ( ! empty( $settings['tags'] ) ) {
			echo '<div class="npsc-card__tags">';
			foreach ( $settings['tags'] as $tag ) {
				if ( ! empty( $tag['tag_text'] ) ) {
					echo '<span class="npsc-tag">' . esc_html( $tag['tag_text'] ) . '</span>';
				}
			}
			echo '</div>';
		} else {
			echo '<span></span>';
		}

		if ( 'yes' === $settings['show_rating'] ) {
			echo '<span class="npsc-card__rating">';
			Icons_Manager::render_icon( $settings['rating_icon'], [ 'aria-hidden' => 'true' ] );
			echo esc_html( $settings['rating_value'] );
			echo '</span>';
		}

		echo '</div>';
	}

	/**
	 * Descriptions are hard-capped at 500 characters. Anything past 120
	 * characters is shown as a short excerpt with a CSS-only (no JS)
	 * "See More" / "See Less" toggle that reveals the full text.
	 */
	private function render_description( $settings ) {
		if ( 'yes' !== $settings['show_description'] || empty( $settings['description'] ) ) {
			return;
		}

		$full  = mb_substr( $settings['description'], 0, 500 );
		$short = wp_html_excerpt( $full, 120, '…' );

		if ( $short === $full ) {
			echo '<p class="npsc-card__desc">' . esc_html( $full ) . '</p>';
			return;
		}

		$toggle_id = 'npsc-desc-' . $this->get_id();
		?>
		<div class="npsc-card__desc-wrap">
			<input type="checkbox" id="<?php echo esc_attr( $toggle_id ); ?>" class="npsc-card__desc-toggle" hidden />
			<p class="npsc-card__desc npsc-card__desc--short"><?php echo esc_html( $short ); ?></p>
			<p class="npsc-card__desc npsc-card__desc--full"><?php echo esc_html( $full ); ?></p>
			<label for="<?php echo esc_attr( $toggle_id ); ?>" class="npsc-card__desc-toggle-label">
				<span class="npsc-card__desc-more"><?php esc_html_e( 'See More', 'single-card-designs-for-elementor' ); ?></span>
				<span class="npsc-card__desc-less"><?php esc_html_e( 'See Less', 'single-card-designs-for-elementor' ); ?></span>
			</label>
		</div>
		<?php
	}

	private function render_body( $settings ) {
		echo '<div class="npsc-card__body">';

		echo '<div class="npsc-card__title-row">';
		if ( ! empty( $settings['title'] ) ) {
			echo '<h3 class="npsc-card__title">' . esc_html( $settings['title'] ) . '</h3>';
		}
		if ( ! empty( $settings['highlight_badge'] ) ) {
			echo '<span class="npsc-card__highlight">' . esc_html( $settings['highlight_badge'] ) . '</span>';
		}
		echo '</div>';

		$this->render_description( $settings );

		if ( ! empty( $settings['author_text'] ) ) {
			echo '<span class="npsc-card__author">' . esc_html( $settings['author_text'] ) . '</span>';
		}

		if ( 'yes' === $settings['show_button'] && ! empty( $settings['button_text'] ) ) {
			$has_link = ! empty( $settings['button_link']['url'] );

			if ( $has_link ) {
				$this->add_link_attributes( 'button_link', $settings['button_link'] );
				echo '<a ' . $this->get_render_attribute_string( 'button_link' ) . ' class="npsc-card__button">' . esc_html( $settings['button_text'] ) . '</a>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			} else {
				echo '<span class="npsc-card__button">' . esc_html( $settings['button_text'] ) . '</span>';
			}
		}

		echo '</div>';
	}

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$image_url = $this->get_image_url( $settings );
		$is_overlay = 'template_2' === $settings['template'];

		if ( $is_overlay ) {
			$style = $image_url ? ' style="background-image:url(' . esc_url( $image_url ) . ');"' : '';
			echo '<div class="npsc-card npsc-card--overlay"' . $style . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo '<div class="npsc-card__gradient"></div>';
			$this->render_tags_and_rating( $settings );
			$this->render_dots( $settings );
			$this->render_body( $settings );
			echo '</div>';
			return;
		}
		?>
		<div class="npsc-card npsc-card--light">
			<div class="npsc-card__media">
				<?php if ( $image_url ) : ?>
					<img class="npsc-card__img" src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $settings['title'] ); ?>" />
				<?php endif; ?>
				<?php $this->render_tags_and_rating( $settings ); ?>
				<?php $this->render_dots( $settings ); ?>
			</div>
			<?php $this->render_body( $settings ); ?>
		</div>
		<?php
	}
}
