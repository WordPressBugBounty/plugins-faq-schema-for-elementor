<?php

namespace ElementorFaqSchema\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class ElementorFaqSchema extends Widget_Base
{

    public function get_name()
    {
        return 'elementor-faq-schema';
    }

    public function get_title()
    {
        return __('FAQ Schema', 'elementor-faq-schema');
    }

    public function get_icon()
    {
        return 'fa fa-pencil';
    }

    public function get_categories()
    {
        return ['general'];
    }

    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since 2.1.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords()
    {
        return ['faq', 'schema'];
    }

    /**
     * Register the widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     */
    protected function _register_controls()
    {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Content', 'elementor-faq-schema'),
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'faq_question',
            [
                'label' => __('Question', 'elementor-faq-schema'),
                'type' => Controls_Manager::TEXTAREA,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => __('Question', 'elementor-faq-schema'),
            ]
        );

        $repeater->add_control(
            'faq_answer',
            [
                'label' => __('Answer', 'elementor-faq-schema'),
                'type' => Controls_Manager::WYSIWYG,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => __('Answer', 'elementor-faq-schema'),
            ]
        );

        $this->add_control(
            'faq',
            [
                'label' => __('FAQs', 'elementor-faq-schema'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ faq_question }}}',
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render the widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     */
    protected function render()
    {
        $faqs = $this->get_settings_for_display()["faq"];
?>
        <?php foreach ($faqs as $index => $item) : ?>
            <?php if ($index == 0) : ?>
                <script type="application/ld+json">
                    {
                        "@context": "https://schema.org",
                        "@type": "FAQPage",
                        "mainEntity": [
                        <?php endif; ?> {
                            "@type": "Question",
                            "name": "<?php echo nl2br($item["faq_question"]); ?>",
                            "acceptedAnswer": {
                                "@type": "Answer",
                                "text": "<?php echo esc_html($item["faq_answer"]); ?>"
                            }
                            <?php if ($index < count($faqs) - 1) : ?>
                        },
                        <?php elseif ($index == count($faqs) - 1) : ?>
                        }
                    ]
                    }
                </script>
            <?php endif; ?>
        <?php endforeach; ?>
<?php
    }

    /**
     * Render the widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 1.1.0
     *
     * @access protected
     */
    // protected function _content_template() {
    //   ?-->

    // <--?php
    // }
}
