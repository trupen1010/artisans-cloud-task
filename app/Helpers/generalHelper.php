<?php

if (! function_exists('public_assets')) {
    /**
     * Returns the path to a public asset.
     *
     * @param  string  $file  The name of the asset file.
     * @param  bool  $is_admin  Whether the asset is for the admin section. Defaults to false.
     * @return string The path to the asset.
     */
    function public_assets(string $file, bool $is_admin = false): string
    {
        $path = (($is_admin === true) ? 'admin' : 'front');

        return "/assets/$path/$file";
    }
}
