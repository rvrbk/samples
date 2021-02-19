<?php

/**
 * @author Rik Verbeek
 * @since 2021-02-10
 * 
 * Navigate through a ghost filesystem
 */
class Path {
    public $currentPath;

    private static $seperator = '/';
    
    public function __construct(string $path) {
        // Start navigating
        $this->cd($path);
    }

    /**
     * @author Rik Verbeek
     * @since 2021-02-10
     * @param string $path
     * 
     * Construct a path
     */
    public function cd(string $path) : void {
        // Explode into array so we can recontruct it accordingly
        $nodes = explode(self::$seperator, $path);
        
        if(count($nodes) > 0) {
            // If the root (/) indicator is used start afresh
            if($nodes[0] == '') {
                $this->currentPath = '';

                unset($nodes[0]);

                $nodes = array_values($nodes);
            }
            
            foreach($nodes as $node) {
                // If $node represents any operations catch them here (there's only one now but for the sake of expandability we do it like this)
                if(in_array($node, ['..'])) {
                    // Strip the last node
                    $this->currentPath = substr($this->currentPath, 0, strrpos($this->currentPath, self::$seperator));
                }
                else {
                    $this->currentPath .= self::$seperator . $node;
                }
            }
        }
    }
}

$path = new Path('path/to/nowhere');

$path->cd('../../to/somewhere');

echo $path->currentPath;