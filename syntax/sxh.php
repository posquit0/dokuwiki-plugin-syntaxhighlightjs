<?php
/**
 * DokuWiki Plugin syntaxhighlightjs (Syntax Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  Claud D. Park <posquit0.bj@gmail.com>
 */

// must be run within Dokuwiki
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN', DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');

class syntax_plugin_syntaxhighlightjs_sxh extends DokuWiki_Syntax_Plugin {
    /**
     * @return string Syntax mode type
     */
    public function getType() {
        return 'protected';
    }
    /**
     * @return string Paragraph type
     */
    public function getPType() {
        return 'block';
    }
    /**
     * @return int Sort order - Low numbers go before high numbers
     */
    public function getSort() {
        return 195;
    }

    /**
     * Connect lookup pattern to lexer.
     *
     * @param string $mode Parser mode
     */
    public function connectTo($mode) {
        $syntax = $this->getConf('syntax');
        $special_pattern = '<'.$syntax.'\b[^>\r\n]*?/>';
        $entry_pattern = '<'.$syntax.'\b.*?>\s*(?=.*?</'.$syntax.'>)';

        $this->Lexer->addSpecialPattern(
            $special_pattern,
            $mode,
            'plugin_syntaxhighlightjs_'.$this->getPluginComponent()
        );
        $this->Lexer->addEntryPattern(
            $entry_pattern,
            $mode,
            'plugin_syntaxhighlightjs_'.$this->getPluginComponent()
        );
    }

    public function postConnect() {
        $syntax = $this->getConf('syntax');
        $exit_pattern = '</'.$syntax.'>';

        $this->Lexer->addExitPattern(
            $exit_pattern,
            'plugin_syntaxhighlightjs_'.$this->getPluginComponent()
        );
    }

    /**
     * Handle matches of the highlightjs syntax
     *
     * @param string $match The match of the syntax
     * @param int    $state The state of the handler
     * @param int    $pos The position in the document
     * @param Doku_Handler    $handler The handler
     * @return array Data for the renderer
     */
    public function handle($match, $state, $pos, Doku_Handler $handler){
        $data = array();

        switch ($state) {
            case DOKU_LEXER_ENTER:
            case DOKU_LEXER_SPECIAL:
                $data = strtolower(trim(substr($match, strpos($match, ' '), -1), " \t\n/"));
                return array($state, $data);

            case DOKU_LEXER_UNMATCHED:
                $handler->_addCall('cdata', array($match), $pos);
                break;

            case DOKU_LEXER_EXIT:
                return array($state, '');
        }

        return false;
    }

    /**
     * Render xhtml output or metadata
     *
     * @param string         $mode      Renderer mode (supported modes: xhtml)
     * @param Doku_Renderer  $renderer  The renderer
     * @param array          $_data      The data from the handler() function
     * @return bool If rendering was successful.
     */
    public function render($mode, Doku_Renderer $renderer, $_data) {
        if (empty($_data)) return false;
        list($state, $data) = $_data;

        if ($mode == 'xhtml') {
            /** @var Doku_Renderer_xhtml $renderer */
            switch ($state) {
                case DOKU_LEXER_ENTER:
                case DOKU_LEXER_SPECIAL:
                    $helper = $this->loadHelper('syntaxhighlightjs');
                    $attr = $helper->buildAttributes($data);

                    $renderer->doc .= '<pre class=\'hljs-wrap\'><code'.$attr.'>';
                    if ($state == DOKU_LEXER_SPECIAL) $renderer->doc .= '</code></pre>';
                    break;

                case DOKU_LEXER_EXIT:
                    $renderer->doc .= '</code></pre>';
                    break;
            }
            return true;
        }

        return false;
    }
}

// vim:ts=4:sw=4:et:
