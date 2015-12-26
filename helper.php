<?php
/**
 * DokuWiki Plugin syntaxhighlightjs (Helper Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  Claud D. Park <posquit0.bj@gmail.com>
 */

// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

class helper_plugin_syntaxhighlightjs extends DokuWiki_Plugin {
    /**
     * get attributes (pull apart the string between '<sxh' and '>')
     *  and identify classes and width
     *
     * @author Claud D. Park <posquit0.bj@gmail.com>
     *   (parts taken from http://www.dokuwiki.org/plugin:wrap)
     */
    function getAttributes($data) {

        $attr = array();
        $tokens = preg_split('/\s+/', $data, 9);
        $restrictedClasses = $this->getConf('restrictedClasses');
        if ($restrictedClasses) {
            $restrictedClasses = array_map('trim', explode(',', $this->getConf('restrictedClasses')));
        }

        foreach ($tokens as $token) {
            // trim unnormal chracters cause of mis-parsing
            $token = trim($token, '<>');

            // get width
            if (preg_match('/^\d*\.?\d+(%|px|em|ex|pt|pc|cm|mm|in)$/', $token)) {
                $attr['width'] = $token;
                continue;
            }

            // get classes
            // restrict token (class names) characters to prevent any malicious data
            if (preg_match('/[^A-Za-z0-9_\-]/', $token)) continue;
            if ($restrictedClasses) {
                $classIsInList = in_array(trim($token), $restrictedClasses);
                // disallow certain classes
                if ($classIsInList) continue;
            }
            $attr['class'] = (isset($attr['class']) ? $attr['class'].' ' : '').$token;
        }

        return $attr;
    }

    /**
     * build attributes (write out classes and width)
     */
    function buildAttributes($data, $addClass='', $mode='xhtml') {

        $attr = $this->getAttributes($data);
        $out = '';

        if ($mode=='xhtml') {
            if($attr['class']) $out .= ' class="'.hsc($attr['class']).' '.$addClass.'"';
            // if used in other plugins, they might want to add their own class(es)
            elseif($addClass)  $out .= ' class="'.$addClass.'"';
            // width on spans normally doesn't make much sense, but in the case of floating elements it could be used
            if($attr['width']) {
                if (strpos($attr['width'],'%') !== false) {
                    $out .= ' style="width: '.hsc($attr['width']).';"';
                } else {
                    // anything but % should be 100% when the screen gets smaller
                    $out .= ' style="width: '.hsc($attr['width']).'; max-width: 100%;"';
                }
            }
        }

        return $out;
    }
}
