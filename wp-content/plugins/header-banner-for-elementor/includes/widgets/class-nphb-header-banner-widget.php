<?php
namespace NPHB\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Header Banner — a fully customizable page-header/hero section with a
 * static or dynamic title, background image, and full style controls.
 */
class Header_Banner_Widget extends Widget_Base {

	public function get_name() {
		return 'nphb-header-banner';
	}

	public function get_title() {
		return esc_html__( 'Header Banner', 'header-banner-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-header';
	}

	public function get_categories() {
		return [ 'np-widgets' ];
	}

	public function get_keywords() {
		return [ 'header', 'banner', 'hero', 'title', 'page header' ];
	}

	public function get_style_depends() {
		return [ 'nphb-header-banner' ];
	}

	protected function register_controls() {
		$this->register_content_controls();
		$this->register_style_background_controls();
		$this->register_style_title_controls();
		$this->register_style_layout_controls();
		$this->register_style_modern_controls();
	}

	/* ------------------------------------------------------------------ */
	/* Content                                                            */
	/* ------------------------------------------------------------------ */

	private function register_content_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Title', 'header-banner-for-elementor' ),
			]
		);

		$this->add_control(
			'template',
			[
				'label'   => esc_html__( 'Template', 'header-banner-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'template_1',
				'options' => [
					'template_1' => esc_html__( 'Template 1 — Classic', 'header-banner-for-elementor' ),
					'template_2' => esc_html__( 'Template 2 — Modern', 'header-banner-for-elementor' ),
				],
				'description' => esc_html__( 'Template 2 adds an optional badge label, a decorative center line, and a scalloped bottom edge.', 'header-banner-for-elementor' ),
			]
		);

		$this->add_control(
			'badge_text',
			[
				'label'       => esc_html__( 'Badge Label', 'header-banner-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => esc_html__( 'UI is for', 'header-banner-for-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'description' => esc_html__( 'Small label shown in a circular badge above the title. Leave empty to hide it.', 'header-banner-for-elementor' ),
				'condition'   => [ 'template' => 'template_2' ],
			]
		);

		$this->add_control(
			'heading_source',
			[
				'label'   => esc_html__( 'Title Source', 'header-banner-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'static',
				'options' => [
					'static'  => esc_html__( 'Static Text', 'header-banner-for-elementor' ),
					'dynamic' => esc_html__( 'Dynamic', 'header-banner-for-elementor' ),
				],
			]
		);

		$this->add_control(
			'heading_static',
			[
				'label'       => esc_html__( 'Title', 'header-banner-for-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 2,
				'label_block' => true,
				'default'     => esc_html__( 'About Us', 'header-banner-for-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'description' => esc_html__( 'Press Enter for a two-line title.', 'header-banner-for-elementor' ),
				'condition'   => [ 'heading_source' => 'static' ],
			]
		);

		$this->add_control(
			'heading_dynamic',
			[
				'label'       => esc_html__( 'Dynamic Value', 'header-banner-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'current_title',
				'options'     => [
					'current_title' => esc_html__( 'Current Page / Post Title', 'header-banner-for-elementor' ),
					'site_title'    => esc_html__( 'Site Title', 'header-banner-for-elementor' ),
					'site_tagline'  => esc_html__( 'Site Tagline', 'header-banner-for-elementor' ),
				],
				'description' => esc_html__( '"Current Page / Post Title" automatically shows the title of whichever page, post, or archive this banner is placed on.', 'header-banner-for-elementor' ),
				'condition'   => [ 'heading_source' => 'dynamic' ],
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'     => esc_html__( 'Alignment', 'header-banner-for-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [ 'title' => esc_html__( 'Left', 'header-banner-for-elementor' ), 'icon' => 'eicon-text-align-left' ],
					'center' => [ 'title' => esc_html__( 'Center', 'header-banner-for-elementor' ), 'icon' => 'eicon-text-align-center' ],
					'right'  => [ 'title' => esc_html__( 'Right', 'header-banner-for-elementor' ), 'icon' => 'eicon-text-align-right' ],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .nphb-banner__inner' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/* ------------------------------------------------------------------ */
	/* Style — background / box                                          */
	/* ------------------------------------------------------------------ */

	private function register_style_background_controls() {
		$this->start_controls_section(
			'section_style_background',
			[
				'label' => esc_html__( 'Background', 'header-banner-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'background_color',
			[
				'label'     => esc_html__( 'Background Color', 'header-banner-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#101756',
				'selectors' => [
					'{{WRAPPER}} .nphb-banner' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'background_source',
			[
				'label'       => esc_html__( 'Background Image Source', 'header-banner-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'media',
				'options'     => [
					'media'          => esc_html__( 'Media Library', 'header-banner-for-elementor' ),
					'featured_image' => esc_html__( 'Featured Image', 'header-banner-for-elementor' ),
				],
				'description' => esc_html__( '"Featured Image" automatically uses the featured image of whichever page/post this banner is placed on. If that page has no featured image set, no background image will show.', 'header-banner-for-elementor' ),
			]
		);

		$this->add_control(
			'background_image',
			[
				'label'     => esc_html__( 'Background Image', 'header-banner-for-elementor' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [ 'url' => '' ],
				'condition' => [ 'background_source' => 'media' ],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'    => 'background_image',
				'default' => 'full',
			]
		);

		$this->add_control(
			'background_position',
			[
				'label'     => esc_html__( 'Image Position', 'header-banner-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'center center',
				'options'   => [
					'center center' => esc_html__( 'Center Center', 'header-banner-for-elementor' ),
					'center top'    => esc_html__( 'Center Top', 'header-banner-for-elementor' ),
					'center bottom' => esc_html__( 'Center Bottom', 'header-banner-for-elementor' ),
					'left center'   => esc_html__( 'Left Center', 'header-banner-for-elementor' ),
					'right center'  => esc_html__( 'Right Center', 'header-banner-for-elementor' ),
				],
				'selectors' => [
					'{{WRAPPER}} .nphb-banner' => 'background-position: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'heading_overlay',
			[
				'label'     => esc_html__( 'Overlay', 'header-banner-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'overlay_color',
			[
				'label'     => esc_html__( 'Overlay Color', 'header-banner-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#101756',
				'selectors' => [
					'{{WRAPPER}} .nphb-banner__overlay' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'overlay_opacity',
			[
				'label'     => esc_html__( 'Overlay Opacity', 'header-banner-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 'px' => [ 'min' => 0, 'max' => 1, 'step' => 0.05 ] ],
				'default'   => [ 'size' => 0.55 ],
				'selectors' => [
					'{{WRAPPER}} .nphb-banner__overlay' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/* ------------------------------------------------------------------ */
	/* Style — title                                                      */
	/* ------------------------------------------------------------------ */

	private function register_style_title_controls() {
		$this->start_controls_section(
			'section_style_title',
			[
				'label' => esc_html__( 'Title', 'header-banner-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'header-banner-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .nphb-banner__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .nphb-banner__title',
				'fields_options' => [
					'font_size' => [
						'default' => [ 'unit' => 'px', 'size' => 52 ],
						'tablet_default' => [ 'unit' => 'px', 'size' => 40 ],
						'mobile_default' => [ 'unit' => 'px', 'size' => 30 ],
					],
					'font_weight' => [ 'default' => '700' ],
				],
			]
		);

		$this->add_responsive_control(
			'title_max_width',
			[
				'label'      => esc_html__( 'Max Width', 'header-banner-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [ 'min' => 200, 'max' => 1400 ],
					'%'  => [ 'min' => 10, 'max' => 100 ],
				],
				'selectors'  => [
					'{{WRAPPER}} .nphb-banner__title' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/* ------------------------------------------------------------------ */
	/* Style — layout (box model)                                         */
	/* ------------------------------------------------------------------ */

	private function register_style_layout_controls() {
		$this->start_controls_section(
			'section_style_layout',
			[
				'label' => esc_html__( 'Layout', 'header-banner-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'min_height',
			[
				'label'      => esc_html__( 'Min Height', 'header-banner-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh' ],
				'range'      => [
					'px' => [ 'min' => 100, 'max' => 900 ],
					'vh' => [ 'min' => 10, 'max' => 100 ],
				],
				'default'         => [ 'unit' => 'px', 'size' => 420 ],
				'tablet_default'  => [ 'unit' => 'px', 'size' => 340 ],
				'mobile_default'  => [ 'unit' => 'px', 'size' => 260 ],
				'selectors'  => [
					'{{WRAPPER}} .nphb-banner' => 'min-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'padding',
			[
				'label'      => esc_html__( 'Padding', 'header-banner-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [ 'top' => 60, 'right' => 40, 'bottom' => 60, 'left' => 40, 'unit' => 'px', 'isLinked' => false ],
				'selectors'  => [
					'{{WRAPPER}} .nphb-banner__inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'margin',
			[
				'label'      => esc_html__( 'Margin', 'header-banner-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [ 'top' => 0, 'right' => 0, 'bottom' => 0, 'left' => 0, 'unit' => 'px', 'isLinked' => false ],
				'selectors'  => [
					'{{WRAPPER}} .nphb-banner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'header-banner-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [ 'top' => 24, 'right' => 24, 'bottom' => 24, 'left' => 24, 'unit' => 'px', 'isLinked' => true ],
				'selectors'  => [
					'{{WRAPPER}} .nphb-banner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'box_shadow',
				'selector' => '{{WRAPPER}} .nphb-banner',
			]
		);

		$this->end_controls_section();
	}

	/* ------------------------------------------------------------------ */
	/* Style — Template 2 (Modern)                                        */
	/* ------------------------------------------------------------------ */

	private function register_style_modern_controls() {
		$this->start_controls_section(
			'section_style_modern',
			[
				'label'     => esc_html__( 'Modern Template (Template 2)', 'header-banner-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'template' => 'template_2' ],
			]
		);

		$this->add_control(
			'heading_badge_style',
			[
				'label' => esc_html__( 'Badge', 'header-banner-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'badge_bg_color',
			[
				'label'     => esc_html__( 'Badge Background', 'header-banner-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .nphb-banner__badge' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_text_color',
			[
				'label'     => esc_html__( 'Badge Text Color', 'header-banner-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#101756',
				'selectors' => [
					'{{WRAPPER}} .nphb-banner__badge' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'badge_size',
			[
				'label'      => esc_html__( 'Badge Size', 'header-banner-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 40, 'max' => 140 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 70 ],
				'selectors'  => [
					'{{WRAPPER}} .nphb-banner__badge' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; font-size: calc({{SIZE}}{{UNIT}} * 0.19);',
				],
			]
		);

		$this->add_control(
			'heading_center_line',
			[
				'label'     => esc_html__( 'Center Line', 'header-banner-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'show_center_line',
			[
				'label'        => esc_html__( 'Show Center Line', 'header-banner-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'center_line_color',
			[
				'label'     => esc_html__( 'Center Line Color', 'header-banner-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(255,255,255,0.4)',
				'selectors' => [
					'{{WRAPPER}} .nphb-banner__center-line' => 'background-color: {{VALUE}};',
				],
				'condition' => [ 'show_center_line' => 'yes' ],
			]
		);

		$this->add_control(
			'heading_scallop',
			[
				'label'     => esc_html__( 'Bottom Edge', 'header-banner-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'show_scallop',
			[
				'label'        => esc_html__( 'Show Scalloped Edge', 'header-banner-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'scallop_color',
			[
				'label'       => esc_html__( 'Edge Color', 'header-banner-for-elementor' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#FFFFFF',
				'selectors'   => [
					'{{WRAPPER}} .nphb-banner__scallop' => 'background-color: {{VALUE}};',
				],
				'description' => esc_html__( 'Should match the background color of whatever comes directly after this banner, so the scallops blend in seamlessly.', 'header-banner-for-elementor' ),
				'condition'   => [ 'show_scallop' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'scallop_size',
			[
				'label'      => esc_html__( 'Scallop Size', 'header-banner-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 16, 'max' => 100 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 44 ],
				'selectors'  => [
					'{{WRAPPER}} .nphb-banner__scallop' => '--nphb-scallop-size: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [ 'show_scallop' => 'yes' ],
			]
		);

		$this->end_controls_section();
	}

	/* ------------------------------------------------------------------ */
	/* Render                                                             */
	/* ------------------------------------------------------------------ */

	private function get_title_text( $settings ) {
		if ( 'static' === $settings['heading_source'] ) {
			return $settings['heading_static'];
		}

		switch ( $settings['heading_dynamic'] ) {
			case 'site_title':
				return get_bloginfo( 'name' );

			case 'site_tagline':
				return get_bloginfo( 'description' );

			case 'current_title':
			default:
				if ( is_singular() ) {
					return get_the_title();
				}

				if ( is_archive() || is_search() || is_home() ) {
					return get_the_archive_title();
				}

				return get_bloginfo( 'name' );
		}
	}

	/**
	 * Resolve the background image URL for either source: the Media Library
	 * picker, or the featured image of whichever post this banner renders
	 * on. Both share the same Image Size control.
	 */
	private function get_background_image_url( $settings ) {
		$attachment_id = 0;

		if ( 'featured_image' === $settings['background_source'] ) {
			$post_id = get_the_ID();

			if ( $post_id ) {
				$attachment_id = get_post_thumbnail_id( $post_id );
			}
		} elseif ( ! empty( $settings['background_image']['id'] ) ) {
			$attachment_id = $settings['background_image']['id'];
		}

		if ( $attachment_id ) {
			$src = Group_Control_Image_Size::get_attachment_image_src( $attachment_id, 'background_image', $settings );

			if ( $src ) {
				return $src;
			}
		}

		if ( 'media' === $settings['background_source'] && ! empty( $settings['background_image']['url'] ) ) {
			return $settings['background_image']['url'];
		}

		return '';
	}

	/**
	 * Static titles come from a TEXTAREA so a two-line title can be typed
	 * with Enter; convert those line breaks to <br> safely.
	 */
	private function print_title( $title ) {
		echo nl2br( esc_html( $title ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$title    = $this->get_title_text( $settings );

		$bg_image_url = $this->get_background_image_url( $settings );
		$has_bg_image = ! empty( $bg_image_url );

		$banner_style = $bg_image_url ? ' style="background-image:url(' . esc_url( $bg_image_url ) . ');"' : '';

		$this->add_render_attribute( 'title', 'class', 'nphb-banner__title' );

		if ( 'dynamic' === $settings['heading_source'] ) {
			$this->add_render_attribute( 'title', 'class', 'nphb-banner__title--dynamic' );
		}

		if ( 'template_2' === $settings['template'] ) {
			$this->render_template_2( $settings, $title, $banner_style, $has_bg_image );
			return;
		}
		?>
		<div class="nphb-banner"<?php echo $banner_style; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<?php if ( $has_bg_image ) : ?>
				<div class="nphb-banner__overlay"></div>
			<?php endif; ?>
			<div class="nphb-banner__inner">
				<?php if ( ! empty( $title ) ) : ?>
					<h1 <?php $this->print_render_attribute_string( 'title' ); ?>><?php $this->print_title( $title ); ?></h1>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}

	private function render_template_2( $settings, $title, $banner_style, $has_bg_image ) {
		$this->add_render_attribute( 'title', 'class', 'nphb-banner__title--modern' );

		$show_center_line = 'yes' === $settings['show_center_line'];
		$show_scallop     = 'yes' === $settings['show_scallop'];
		?>
		<div class="nphb-banner nphb-banner--modern"<?php echo $banner_style; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<?php if ( $has_bg_image ) : ?>
				<div class="nphb-banner__overlay"></div>
			<?php endif; ?>
			<?php if ( $show_center_line ) : ?>
				<div class="nphb-banner__center-line"></div>
			<?php endif; ?>
			<div class="nphb-banner__inner">
				<?php if ( ! empty( $settings['badge_text'] ) ) : ?>
					<span class="nphb-banner__badge"><?php echo esc_html( $settings['badge_text'] ); ?></span>
				<?php endif; ?>
				<?php if ( ! empty( $title ) ) : ?>
					<h1 <?php $this->print_render_attribute_string( 'title' ); ?>><?php $this->print_title( $title ); ?></h1>
				<?php endif; ?>
			</div>
			<?php if ( $show_scallop ) : ?>
				<div class="nphb-banner__scallop"></div>
			<?php endif; ?>
		</div>
		<?php
	}
}
