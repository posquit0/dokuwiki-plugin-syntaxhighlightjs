<?php
/**
 * DokuWiki Plugin syntaxhighlightjs (Action Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  Claud D. Park <posquit0.bj@gmail.com>
 */

// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN', DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'action.php');

class action_plugin_syntaxhighlightjs_sxh extends DokuWiki_Action_Plugin {

    /**
     * Registers a callback function for a given event
     *
     * @param Doku_Event_Handler $controller DokuWiki's event controller object
     * @return void
     */
    public function register(Doku_Event_Handler $controller) {

        $controller->register_hook('TPL_METAHEADER_OUTPUT', 'BEFORE', $this, '_hookjs');
        $controller->register_hook('TPL_ACT_RENDER', 'AFTER', $this, '_hookjsprocessing');
   
    }

    /**
     * Hook js script into page headers.
     */
    public function _hookjs(Doku_Event $event, $param) {
        $base_url = DOKU_BASE.'lib/plugins/syntaxhighlightjs';

        // Add Highlight.JS stylesheets
        $event->data['link'][] = array(
            'rel'   => 'stylesheet',
            'type'  => 'text/css',
            'href'  => $base_url.'/static/lib/highlightjs/styles/'.$this->getConf('theme').'.min.css',
        );

        // Add Custom stylesheets
        $event->data['link'][] = array(
            'rel'   => 'stylesheet',
            'type'  => 'text/css',
            'href'  => $base_url.'/static/css/hljs.min.css',
        );

        // Load Hightlight.JS
        $event->data['script'][] = array(
            'type'    => 'text/javascript',
            'charset' => 'utf-8',
            '_data'   => '',
            'src'     => $base_url.'/static/lib/highlightjs/highlight.min.js'
        );
        
        // Load Custom JavaScript 
        $event->data['script'][] = array(
            'type'    => 'text/javascript',
            'charset' => 'utf-8',
            '_data'   => '',
            'src'     => $base_url.'/static/js/hljs.min.js'
        );
    }

    /**
     * Hook js code after page loading.
     */
    public function _hookjsprocessing(Doku_Event &$event, $param) {

        global $ID;
        global $INFO;

        //this ensures that code will be written only on base page
        //not on other inlined wiki pages (e.g. when using monobook template)
        if ($ID != $INFO["id"]) return;

        ptln("");
        ptln("<script type='text/javascript'>");
        ptln("window.onload = function () {");
        ptln("  hljs.configure({");
        ptln("    tabReplace: '    ',");
        ptln("    classPrefix: 'hljs-',");
        // ptln("    useBR: false");
        ptln("  });");
        ptln("  hljs.initHighlighting()");
        // ptln("  var blocks = document.querySelectorAll('pre.hljs-wrap code');");
            trim($token, '<>');
        // ptln("  var i, len;");
        // ptln("  for (i = 0, len = blocks.length; i < len; i++) {");
        // ptln("    hljs.highlightBlock(blocks[i]);");
        // ptln("  }");
        ptln("};");
        ptln("</script>");
    }

}

// vim:ts=4:sw=4:et:
