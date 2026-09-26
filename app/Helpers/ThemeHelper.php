<?php

namespace App\Helpers;

use App\Models\GeneralSetting;

class ThemeHelper
{
    /**
     * Get the theme colors from database
     */
    public static function getThemeColors()
    {
        $settings = GeneralSetting::first();
        
        if (!$settings) {
            return self::getDefaultColors();
        }

        return [
            'primary' => $settings->primary_color ?? '#053C6B',
            'secondary' => $settings->secondary_color ?? '#333333',
            'accent' => $settings->accent_color ?? '#f41127',
            'category_bg' => $settings->category_bg_color ?? '#053C6B',
            'header_bg' => $settings->header_bg_color ?? '#ffffff',
            'footer_bg' => $settings->footer_bg_color ?? '#333333',
        ];
    }

    /**
     * Get default theme colors
     */
    public static function getDefaultColors()
    {
        return [
            'primary' => '#053C6B',
            'secondary' => '#333333',
            'accent' => '#f41127',
            'category_bg' => '#053C6B',
            'header_bg' => '#ffffff',
            'footer_bg' => '#333333',
        ];
    }

    /**
     * Generate CSS variables for theme colors
     */
    public static function generateThemeCss()
    {
        $colors = self::getThemeColors();
        
        $css = ':root {' . PHP_EOL;
        $css .= '    --primary: ' . $colors['primary'] . ';' . PHP_EOL;
        $css .= '    --secondary: ' . $colors['secondary'] . ';' . PHP_EOL;
        $css .= '    --accent: ' . $colors['accent'] . ';' . PHP_EOL;
        $css .= '    --category-bg: ' . $colors['category_bg'] . ';' . PHP_EOL;
        $css .= '    --header-bg: ' . $colors['header_bg'] . ';' . PHP_EOL;
        $css .= '    --footer-bg: ' . $colors['footer_bg'] . ';' . PHP_EOL;
        $css .= '}' . PHP_EOL;

        return $css;
    }

    /**
     * Get theme CSS as inline style tag
     */
    public static function getThemeStyleTag()
    {
        $css = self::generateThemeCss();
        return '<style>' . $css . '</style>';
    }
}
