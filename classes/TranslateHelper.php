<?php namespace Miravo\Timetracker\Classes;

class TranslateHelper
{
    public static function string($label = null) {

        if ($label) {
            $locale = \App::getLocale(); // Get the current locale, e.g., "fr-ca"
            $languageCode = substr($locale, 0, 2); // Extract the language code, e.g., "fr"
            
            // Build the path to the JSON file
            $pluginPath = plugins_path('miravo/timetracker/lang/' . $languageCode . '.json');
    
            if (file_exists($pluginPath)) {
                $translations = json_decode(file_get_contents($pluginPath), true);
    
                if (isset($translations[$label])) {
                    return $translations[$label];
                }
            }
    
            // Fallback logic if label is not found
            return $label;
        }
    
        return null;
    }

}