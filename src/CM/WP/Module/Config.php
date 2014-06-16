<?php

if (!class_exists('CM_WP_Module_Config')) {

    class CM_WP_Module_Config extends CM_WP_Module {
        
        /**
         * Config settings coded into the plugin
         *
         * @var array
         */
        protected $static_config = array();


        /**
         * Config settings stored in the WP d/b
         *
         * @var array
         */
        protected $dynamic_config = array();


        /**
         * Writes a static config setting
         *
         * @param string $key   Setting name
         *                      Can be a '.' separated hierarchical key
         * @param mixed  $value Value to store for this setting
         *
         * @return $this (for method chaining)
         */
        public function write( $key, $value ) {
            $key_array = explode( '.', $key );

            // Work your way down the tree to the required level
            $key_pointer = &$this->static_config;
            foreach ( $key_array as $level => $key_part ) {
                if ( empty($key_pointer[$key_part]) || ! is_array( $key_pointer[$key_part] ) ) {
                    $key_pointer[$key_part] = array();
                }
                $key_pointer = &$key_pointer[$key_part];
            }
            $key_pointer = $value;

            return $this;
        }


        /**
         * Reads a static config setting
         *
         * @param string $key   Setting name
         *                      Can be a '.' separated hierarchicalkey
         *
         * @return mixed Value of the config setting
         */
        public function read( $key ) {

            if ( empty( $key ) ) {
                return $this->static_config;
            }

            $key_array = explode( '.', $key );

            $key_pointer = &$this->static_config;
            foreach ( $key_array as $key_part ) {
                // For non-last level keys, navigate down the tree
                if ( ! isset( $key_pointer[$key_part] ) ) {
                    return null;
                }
                $key_pointer = &$key_pointer[$key_part];
            }
            return $key_pointer;
        }
    }
}