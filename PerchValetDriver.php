<?php

class PerchValetDriver extends BasicValetDriver
{
    /**
     * Determine if the driver serves the request.
     *
     * @param  string  $sitePath
     * @param  string  $siteName
     * @param  string  $uri
     * @return bool
     */
    public function serves($sitePath, $siteName, $uri)
    {
        if (strpos($uri, 'admin') !== false || strpos($uri, 'perch') !== false) {
          return false;
        }

        return file_exists($sitePath.'/admin/core/lib/Perch.class.php');
    }

    /**
     * Get the fully resolved path to the application's front controller.
     *
     * @param  string  $sitePath
     * @param  string  $siteName
     * @param  string  $uri
     * @return string
     */
    public function frontControllerPath($sitePath, $siteName, $uri)
    {
        $_SERVER['PHP_SELF']    = $uri;
        $_SERVER['SERVER_ADDR'] = '127.0.0.1';
        $_SERVER['SERVER_NAME'] = $_SERVER['HTTP_HOST'];
        $_SERVER['REQUEST_URI'] = $uri;

        return parent::frontControllerPath(
            $sitePath, $siteName, $this->forceCleanURL($uri)
        );
    }

    /**
     * Rewrite cleaner URL
     *
     * @param  string $uri
     * @return string
     */
    private function forceCleanURL($uri)
    {
        if (strpos($uri, 'admin') !== false || strpos($uri, 'perch') !== false) {
          return $uri;
        }

        if (strpos($uri, '.php') == false ) {
          return $uri . '.php';
        }
    }
}