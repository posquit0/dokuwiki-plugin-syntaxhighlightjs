<?php
/**
 * Options for the syntaxhighlightjs plugin
 *
 * @author Claud D. Park <posquit0.bj@gmail.com>
 */


$meta['syntax'] = array('string');
$meta['theme'] = array(
    'multichoice', '_choices' => array(
        'agate', 'androidstudio', 'arta', 'ascetic',
        'atelier-cave-dark', 'atelier-cave-light',
        'atelier-dune-dark', 'atelier-dune-light',
        'atelier-estuary-dark', 'atelier-estuary-light',
        'atelier-forest-dark', 'atelier-forest-light',
        'atelier-heath-dark', 'atelier-heath-light',
        'atelier-lakeside-dark', 'atelier-lakeside-light',
        'atelier-plateau-dark', 'atelier-plateau-light',
        'atelier-savanna-dark', 'atelier-savanna-light',
        'atelier-seaside-dark', 'atelier-seaside-light',
        'atelier-sulphurpool-dark', 'atelier-sulphurpool-light',
        'brown-paper', 'brown-papersq', 'codepen-embed',
        'color-brewer', 'dark', 'darkula', 'default', 'docco',
        'far', 'foundation', 'github-gist', 'github', 'googlecode',
        'grayscale', 'hopscotch', 'hybrid', 'idea', 'ir-black',
        'kimbie.dark', 'kimbie.light', 'magula', 'mono-blue',
        'monokai-sublime', 'monokai', 'obsidian',
        'paraiso-dark', 'paraiso-light', 'pojoaque', 'railscasts',
        'rainbow', 'school-book', 'solarized-dark', 'solarized-light',
        'sunburst', 'tomorrow-night-blue', 'tomorrow-night-bright',
        'tomorrow-night-eighties', 'tomorrow-night', 'tomorrow',
        'vs', 'xcode', 'zenburn'
    )
);
$meta['restrictedClasses'] = array('string');
