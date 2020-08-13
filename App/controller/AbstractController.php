<?php
class AbstractController {

    public function render($view) {
        $part = Routing::getPathParts();
        require ( __DIR__. "/../views/$part[1]/$view.php");
    }
}
