<?php
/**
 * DokuWiki Plugin highlightjs (Syntax Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  Claud D. Park <posquit0.bj@gmail.com>
 */

// must be run within Dokuwiki
if (!defined('DOKU_INC')) die();

class syntax_plugin_highlightjs_sxh extends DokuWiki_Syntax_Plugin {
    /**
     * @return string Syntax mode type
     */
    public function getType() {
        return 'FIXME: container|baseonly|formatting|substition|protected|disabled|paragraphs';
    }
    /**
     * @return string Paragraph type
     */
    public function getPType() {
        return 'FIXME: normal|block|stack';
    }
    /**
     * @return int Sort order - Low numbers go before high numbers
     */
    public function getSort() {
        return FIXME;
    }

    /**
     * Connect lookup pattern to lexer.
     *
     * @param string $mode Parser mode
     */
    public function connectTo($mode) {
        $this->Lexer->addSpecialPattern('<FIXME>',$mode,'plugin_highlightjs_sxh');
//        $this->Lexer->addEntryPattern('<FIXME>',$mode,'plugin_highlightjs_sxh');
    }

//    public function postConnect() {
//        $this->Lexer->addExitPattern('</FIXME>','plugin_highlightjs_sxh');
//    }

    /**
     * Handle matches of the highlightjs syntax
     *
     * @param string $match The match of the syntax
     * @param int    $state The state of the handler
     * @param int    $pos The position in the document
     * @param Doku_Handler    $handler The handler
     * @return array Data for the renderer
     */
    public function handle($match, $state, $pos, Doku_Handler &$handler){
        $data = array();

        return $data;
    }

    /**
     * Render xhtml output or metadata
     *
     * @param string         $mode      Renderer mode (supported modes: xhtml)
     * @param Doku_Renderer  $renderer  The renderer
     * @param array          $data      The data from the handler() function
     * @return bool If rendering was successful.
     */
    public function render($mode, Doku_Renderer &$renderer, $data) {
        if($mode != 'xhtml') return false;

        return true;
    }
}

// vim:ts=4:sw=4:et:
