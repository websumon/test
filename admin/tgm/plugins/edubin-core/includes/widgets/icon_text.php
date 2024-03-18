<?php
namespace Elementor;

if (!defined('ABSPATH')) {
	exit;
}
// Exit if accessed directly

use Elementor\{Widget_Base, Controls_Manager, Group_Control_Typography, Repeater, Icons_Manager};
use RTAddons\Gostudy_Global_Variables as Gostudy_Globals;

class Edubin_Elementor_Widget_Icon_Text extends Widget_Base {

	public function get_name() {
		return 'edubin-icon-text';
	}

	public function get_title() {
		return __('Icon + Text', 'edubin-core');
	}
    public function get_keywords() {
        return [ 'icon text', 'icon', 'text icon', 'list icon'];
    }
	public function get_icon() {
		return 'edubin-icon eicon-icon-box';
	}
	public function get_categories() {
		return ['edubin-core'];
	}

    protected function register_controls()
    {
        /*-----------------------------------------------------------------------------------*/
        /*  CONTENT -> GENERAL
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_content_general',
            ['label' => esc_html__('General', 'edubin-core')]
        );

        $this->add_control(
            'view',
            [
                'label' => esc_html__('Layout', 'edubin-core'),
                'type' => Controls_Manager::HIDDEN,
                'label_block' => false,
                'classes' => 'elementor-control-start-end',
                'default' => 'inline',
                'prefix_class' => 'elementor-icon-list--layout-',
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'text',
            [
                'label' => esc_html__('Text', 'edubin-core'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'dynamic' => ['active' => true],
                'placeholder' => esc_attr__('List Item', 'edubin-core'),
                'default' => esc_html__('List Item', 'edubin-core'),
            ]
        );

        $repeater->add_control(
            'selected_icon_fontawesome',
            [
                'label' => esc_html__('Icon', 'edubin-core'),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'label_block' => true,
                'default' => [
                    'value' => 'fab fa-wordpress',
                    'library' => 'fa-brands',
                ],
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label' => esc_html__('Link', 'edubin-core'),
                'type' => Controls_Manager::URL,
                'dynamic' => ['active' => true],
                'label_block' => true,
                'placeholder' => esc_attr__('https://your-link.com', 'edubin-core'),
            ]
        );

        $this->add_control(
            'icon_list',
            [
                'label' => '',
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    ['text' => esc_html__('List Item #1', 'edubin-core')],
                    ['text' => esc_html__('List Item #2', 'edubin-core')],
                    ['text' => esc_html__('List Item #3', 'edubin-core')],
                ],
                'title_field' => '{{{ text }}}',
            ]
        );
        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> LIST
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_list',
            [
                'label' => esc_html__('List', 'edubin-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'space_between',
            [
                'label' => esc_html__('Gap Items', 'edubin-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['max' => 200],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-items.elementor-inline-items .elementor-icon-list-item' => 'margin-right: calc({{SIZE}}{{UNIT}}/2); margin-left: calc({{SIZE}}{{UNIT}}/2)',
                    '{{WRAPPER}} .elementor-icon-list-items.elementor-inline-items' => 'margin-right: calc(-{{SIZE}}{{UNIT}}/2); margin-left: calc(-{{SIZE}}{{UNIT}}/2)',
                    'body.rtl {{WRAPPER}} .elementor-icon-list-items.elementor-inline-items .elementor-icon-list-item:after' => 'left: calc(-{{SIZE}}{{UNIT}}/2)',
                    'body:not(.rtl) {{WRAPPER}} .elementor-icon-list-items.elementor-inline-items .elementor-icon-list-item:after' => 'right: calc(-{{SIZE}}{{UNIT}}/2)',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_align',
            [
                'label' => esc_html__('Alignment', 'edubin-core'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'edubin-core'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'edubin-core'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'edubin-core'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'prefix_class' => 'elementor%s-align-',
            ]
        );

        $this->add_control(
            'divider',
            [
                'label' => esc_html__('Divider', 'edubin-core'),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before',
                'label_off' => esc_html__('Off', 'edubin-core'),
                'label_on' => esc_html__('On', 'edubin-core'),
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-item:not(:last-child):after' => 'content: \'\'',
                ],
            ]
        );

        $this->add_control(
            'divider_style',
            [
                'label' => esc_html__('Style', 'edubin-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => ['divider' => 'yes'],
                'options' => [
                    'solid' => esc_html__('Solid', 'edubin-core'),
                    'double' => esc_html__('Double', 'edubin-core'),
                    'dotted' => esc_html__('Dotted', 'edubin-core'),
                    'dashed' => esc_html__('Dashed', 'edubin-core'),
                ],
                'default' => 'solid',
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-items.elementor-inline-items .elementor-icon-list-item:not(:last-child):after' => 'border-left-style: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'divider_weight',
            [
                'label' => esc_html__('Weight', 'edubin-core'),
                'type' => Controls_Manager::SLIDER,
                'condition' => ['divider' => 'yes'],
                'range' => [
                    'px' => ['min' => 1, 'max' => 20],
                ],
                'default' => ['size' => 1],
                'selectors' => [
                    '{{WRAPPER}} .elementor-inline-items .elementor-icon-list-item:not(:last-child):after' => 'border-left-width: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'divider_height',
            [
                'label' => esc_html__('Height', 'edubin-core'),
                'type' => Controls_Manager::SLIDER,
                'condition' => ['divider' => 'yes'],
                'size_units' => ['%', 'px'],
                'range' => [
                    'px' => ['min' => 1, 'max' => 100],
                    '%' => ['min' => 1, 'max' => 100],
                ],
                'default' => ['unit' => '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-item:not(:last-child):after' => 'height: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'divider_color',
            [
                'label' => esc_html__('Color', 'edubin-core'),
                'type' => Controls_Manager::COLOR,
                'condition' => ['divider' => 'yes'],
                'dynamic' => ['active' => true],
                'default' => '#ddd',
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-item:not(:last-child):after' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> ICON
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => esc_html__('Icon', 'edubin-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('tabs_icon');

        $this->start_controls_tab(
            'tab_icon_idle',
            ['label' => esc_html__('Idle', 'edubin-core')]
        );

        $this->add_control(
            'icon_color_idle',
            [
                'label' => esc_html__('Color', 'edubin-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-icon-list-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_stacked_color',
            [
                'label' => esc_html__('Stacked Color', 'edubin-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-icon i' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_icon_hover',
            ['label' => esc_html__('Hover', 'edubin-core')]
        );

        $this->add_control(
            'icon_color_hover',
            [
                'label' => esc_html__('Color', 'edubin-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-item:hover .elementor-icon-list-icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-icon-list-item:hover .elementor-icon-list-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Size', 'edubin-core'),
                'type' => Controls_Manager::SLIDER,
                'separator' => 'before',
                'range' => [
                    'px' => ['min' => 6, 'max' => 60],
                ],
                'default' => ['size' => 14],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-icon-list-icon svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_spacing',
            [
                'label' => esc_html__('Gap Icons', 'edubin-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['min' => 0, 'max' => 100],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-icon' => is_rtl() ? 'margin-left:' : 'margin-right:' . ' {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> TEXT
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_text',
            [
                'label' => esc_html__('Text', 'edubin-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'icon_typography',
                'selector' => '{{WRAPPER}} .elementor-icon-list-item',
            ]
        );

        $this->start_controls_tabs('text_color_tabs');

        $this->start_controls_tab(
            'tab_text_idle',
            ['label' => esc_html__('Idle', 'edubin-core')]
        );

        $this->add_control(
            'text_color_idle',
            [
                'label' => esc_html__('Color', 'edubin-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_text_hover',
            ['label' => esc_html__('Hover', 'edubin-core')]
        );

        $this->add_control(
            'text_color_hover',
            [
                'label' => esc_html__('Color', 'edubin-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-item:hover .elementor-icon-list-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'text_indent',
            [
                'label' => esc_html__('Text Indent', 'edubin-core'),
                'type' => Controls_Manager::SLIDER,
                'separator' => 'before',
                'range' => [
                    'px' => ['max' => 50],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-text' => is_rtl() ? 'padding-right: {{SIZE}}{{UNIT}};' : 'padding-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    public function render()
    {
        $settings = $this->get_settings_for_display();
        $fallback_defaults = [
            'fa fa-check',
            'fa fa-times',
            'fa fa-dot-circle-o',
        ];

        $this->add_render_attribute([
            'icon_list' => [
                'class' => [
                    'rt-header-list-info',
                    'elementor-icon-list-items',
                    'elementor-inline-items',
                ],
            ],
            'list_item' => [
                'class' => [
                    'elementor-icon-list-item',
                    'elementor-inline-item'
                ],
            ],
        ]);

        echo '<ul ', $this->get_render_attribute_string('icon_list'), '>';
        foreach ($settings['icon_list'] as $index => $item) :
            $repeater_setting_key = $this->get_repeater_setting_key('text', 'icon_list', $index);

            $this->add_render_attribute($repeater_setting_key, 'class', 'rt-header-list-text elementor-icon-list-text');

            $this->add_inline_editing_attributes($repeater_setting_key);
            $migration_allowed = Icons_Manager::is_migration_allowed();

            echo '<li class="elementor-icon-list-item" >';
            if (!empty($item['link']['url'])) {
                $link_key = 'link_' . $index;

                $this->add_link_attributes($link_key, $item['link']);

                echo '<a ', $this->get_render_attribute_string($link_key), '>';
            }

            // add old default
            if (!isset($item['icon']) && !$migration_allowed) {
                $item['icon'] = $fallback_defaults[$index] ?? 'fa fa-check';
            }

            $migrated = isset($item['__fa4_migrated']['selected_icon_fontawesome']);
            $is_new = !isset($item['icon']) && $migration_allowed;

            if (
                !empty($item['icon'])
                || (!empty($item['selected_icon_fontawesome']['value']) && $is_new)
            ) {
                echo '<span class="rt-header-list-icon elementor-icon-list-icon">';
                if ($is_new || $migrated) {
                    Icons_Manager::render_icon($item['selected_icon_fontawesome'], ['aria-hidden' => 'true']);
                } else {
                    echo '<i class="', esc_attr($item['icon']), '" aria-hidden="true"></i>';
                }
                echo '</span>';
            }

            echo '<span ', $this->get_render_attribute_string($repeater_setting_key), '>',
                $item['text'],
                '</span>';

            if (!empty($item['link']['url'])) {
                echo '</a>';
            }

            echo '</li>';
        endforeach;

        echo '</ul>';
    }
}
