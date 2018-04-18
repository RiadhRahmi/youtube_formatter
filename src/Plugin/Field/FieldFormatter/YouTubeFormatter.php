<?php

namespace Drupal\youtube_formatter\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'youtube' formatter.
 *
 * @FieldFormatter(
 *   id = "youtube_formatter",
 *   label = @Translation("YouTube Formatter"),
 *   field_types = {
 *     "string",
 *
 *   }
 * )
 */
class YouTubeFormatter extends FormatterBase
{
    /**
     * {@inheritdoc}
     */
    public static function defaultSettings()
    {
        return [
                'width' => '100%',
                'height' => '400',
            ] + parent::defaultSettings();
    }

    /**
     * {@inheritdoc}
     */
    public function settingsForm(array $form, FormStateInterface $form_state)
    {
        $element['width'] = [
            '#title' => t('Width'),
            '#type' => 'textfield',
            '#default_value' => $this->getSetting('width'),
        ];

        $element['height'] = [
            '#title' => t('Height'),
            '#type' => 'textfield',
            '#default_value' => $this->getSetting('height'),
        ];

        return $element;
    }


    /**
     * {@inheritdoc}
     */
    public function settingsSummary()
    {
        $summary = [];
        $settings = $this->getSettings();

        if (isset($settings['width'])) {
            $summary[] = t('width  = "@width"', ['@width' => $settings['width']]);
        }else{
            $summary[] = t('width is required');
        }

        if (!empty($settings['height'])) {
            $summary[] = t('height = "@height"', ['@height' => $settings['height']]);
        }else{
            $summary[] = t('height is required');
        }

        return $summary;
    }





    /**
     * Builds a renderable array for a field value.
     *
     * @param \Drupal\Core\Field\FieldItemListInterface $items
     *   The field values to be rendered.
     * @param string $langcode
     *   The language that should be used to render the field.
     *
     * @return array
     *   A renderable array for $items, as an array of child elements keyed by
     *   consecutive numeric indexes starting from 0.
     */
    public function viewElements(FieldItemListInterface $items, $langcode)
    {
        $elements = array();
        $settings = $this->getSettings();

        foreach ($items as $delta => $item) {
            $video_id = $item->value;
            $elements[$delta] = array(
                '#theme' => 'youtube_link_formatter',
                '#video_id' => $video_id,
                '#width' => $settings['width'],
                '#height' => $settings['height'],
            );
        }

        return $elements;
    }






}