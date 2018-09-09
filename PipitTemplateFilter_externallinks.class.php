<?php


class PipitTemplateFilter_externallinks extends PerchTemplateFilter {
    public $returns_markup = true;

    public function filterBeforeProcessing($value, $valueIsMarkup = false) {
        if(defined('SITE_URL')) {
            $site_url = SITE_URL;
        } else {
            $API  = new PerchAPI(1.0, 'content');
            $Settings = $API->get('Settings');
            $site_url = $Settings->get('siteURL')->val();
        }


        $doc = new DOMDocument('1.0', 'UTF-8');
        libxml_use_internal_errors(true);
        $doc->loadHTML(mb_convert_encoding($value, 'HTML-ENTITIES', 'UTF-8'));
        $xpath = new DOMXPath($doc);

        $result = $xpath->query('//a');

        

        foreach($result as $node) {
            $href = $node->getAttribute('href');
            
            if($href && $this->is_external($href, $site_url)) {
                $target = $node->getAttribute('target');
                $rel = $node->getAttribute('rel');

                if(!$target && $this->Tag->linkstarget()) {
                    $node->setAttribute("target", $this->Tag->linkstarget());
                }

                if(!$rel && $this->Tag->linksrel()) {
                    $node->setAttribute("rel", $this->Tag->linksrel());
                }
            }
        }

        libxml_clear_errors();


        $output = $doc->saveHTML($doc->documentElement);
        return $output;
    }





    public function is_external($link, $site_url) {
        $site_domain = $this->get_domain($site_url);
        $link_domain = $this->get_domain($link);
        
        if($link_domain && $site_domain !== $link_domain) {
            return true;
        } 

        return false;
    }



    
    public function get_domain($url) {
        $parts = parse_url($url);

        if(isset($parts['host'])) {
            return $parts['host'];
        }

        return false;
    }
}


PerchSystem::register_template_filter('externallinks', 'PipitTemplateFilter_externalLinks');