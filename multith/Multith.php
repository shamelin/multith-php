<?php

    /**
    *   Copyright 2017 Simon Hamelin
    *
    *   Licensed under the Apache License, Version 2.0 (the "License");
    *   you may not use this file except in compliance with the License.
    *   You may obtain a copy of the License at
    *
    *   http://www.apache.org/licenses/LICENSE-2.0
    *
    *   Unless required by applicable law or agreed to in writing, software
    *   distributed under the License is distributed on an "AS IS" BASIS,
    *   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
    *   See the License for the specific language governing permissions and
    *   limitations under the License.
    **/

    /**
    * Main class of the script.
    * Multith - Multi-theme support on your websites
    **/
    class Multith {
      # GENERAL INFORMATIONS
      protected $PROJECT = null;

      # Modify the lines below to change the functionment of the script.
      public $DATABASE_TYPE = "mysql"; # Set the database type (Where all the themes infos are stored)

      ###############################
      #        DATABASE INFO        #
      ###############################
      public $DATABASE_HOST = "localhost";
      public $DATABASE_PORT = 3306;

      public $DATABASE_NAME = "multith";
      public $DATABASE_USER = "root";
      public $DATABASE_PASS = "";

      protected $DATABASE_CLASS = null;

      # NO MORE MODIFICATIONS! EVERYTHING SHOULD WORK NOW, IF YOU FOLLOWED ALL THE INSTRUCTIONS ON THE REPOSITORY.

      /**
      * Initiate the plugin.
      **/
      public function __construct() {
        # Check if the database type is supported by the script.
        if(file_exists(dirname(__FILE__) . "/Database/" . strtolower($this->DATABASE_TYPE) . ".php")) {
          require_once(dirname(__FILE__) . "/Database/" . strtolower($this->DATABASE_TYPE) . ".php"); # Include database type interface

          if(class_exists($this->DATABASE_TYPE)) { # If the database type inteface class exist
            try {
              $this->DATABASE_CLASS = new $this->DATABASE_TYPE($this); # Call the database type interface and initiate the connection to the database.
            } catch(Exception $e) {
              exit("<b>[MULTITH] Critical error:</b> " . $e->getMessage());
            }
          } else { # Class not found!
            exit("<b>[MULTITH] Critical error:</b> Class for database type " . $this->DATABASE_TYPE . " not found. Please check that the class name in the file \"" . $this->DATABASE_TYPE . ".php\" in the \"Database\" folder of the plugin is equal to the name of the file (case-sensitive)");
          }
        } else { # File not found!
          exit("<b>[MULTITH] Critical error:</b> File for database type " . $this->DATABASE_TYPE . " not found. The database may not be supported or may not have been installed properly.");
        }
      }

      /**
      * Get the project name.
      * @return String Project name
      **/
      public function getProject() {
        return $this->PROJECT;
      }

      /**
      * Set the project.
      * @param String Project name
      **/
      public function setProject($project) {
        $this->PROJECT = $project;
      }

      # The methods below requires a valid connection to a database.

      /**
      * Initiate the theme for a page.
      * @param String Project name
      * @param String Theme name
      **/
      public function Initiate($project, $theme = null) {
        if($project == null && $this->getProject() != null) { # If there is no project name provided but a project has been defined in the class
          $project = $this->getProject();
        } else if($project == null && $this->getProject() == null) { # If there is not enough arguments provided
          return null;
        } else {
          if($this->doesProjectExist($project)) { # If the project given exist.
            $this->setProject($project);
          } else { # Not enough arguments provided to initiate the plugin :(
            return null;
          }
        }

        if(isset($_COOKIE['theme'])) { # If the cookie 'theme' exist, check if it is valid.
          if($this->doesTokenExist($project, $_COOKIE['theme']) && $this->isTokenEnabled($project, $_COOKIE['theme'])) { # If the token exist and if it is enabled. Otherwise, just ignore it.
            $theme = $this->getTokenTheme($project, $_COOKIE['theme']);
          }
        }

        if($theme == null || !$this->doesThemeExist($project, $theme) || !$this->isThemeEnabled($project, $theme)) { # If there is no theme provided or the theme doesn't exist or theme is not enabled
          $theme = $this->getDefaultThemeName($project);
        }

        $stylesheets = $this->getStylesheets($project, $theme);
        $scripts = $this->getScripts($project, $theme);

        for($i = 0 ; $i < count($stylesheets) ; $i++) {
          echo '<link rel="stylesheet" type="text/css" href="' . $stylesheets[$i] . '">';
        }

        for($i = 0 ; $i < count($scripts) ; $i++) {
          echo '<script type="text/javascript" src="' . $scripts[$i] . '"></script>';
        }
      }

      /**
      * Get the default theme of a project.
      * @param String Project name
      * @return String Default theme name
      **/
      public function getDefaultThemeName($project) {
        return $this->DATABASE_CLASS->getDefaultThemeName(str_replace('\'', '\\\'', $project));
      }

      /**
      * Check if a theme exist in a project.
      * @param String Project name
      * @param String Theme name
      * @return Boolean Theme exist
      **/
      public function doesThemeExist($project, $theme) {
        return $this->DATABASE_CLASS->doesThemeExist($project, $theme);
      }

      /**
      * Check if a project exist.
      * @param String Project name
      * @return Boolean Project exist
      **/
      public function doesProjectExist($project) {
        return $this->DATABASE_CLASS->doesProjectExist($project);
      }

      /**
      * Check if a theme is enabled.
      * @param String Project name
      * @param String Theme name
      * @return Boolean Is enabled
      **/
      public function isThemeEnabled($project, $theme) {
        if($this->doesThemeExist($project, $theme)) { # If the theme exist.
          return $this->DATABASE_CLASS->isThemeEnabled($project, $theme);
        } else { # No token, not enabled.
          return null;
        }
      }

      /**
      * Get the stylesheets of a theme.
      * @param String Project name
      * @param String Theme name
      * @return Array Stylesheets
      **/
      public function getStylesheets($project, $theme) {
        if($this->doesThemeExist($project, $theme)) { # If the theme exist.
          return $this->DATABASE_CLASS->getStylesheets($project, $theme);
        } else { # Theme doesn't exist, there is no point of return an empty array
          return null;
        }
      }

      /**
      * Get the scripts of a theme.
      * @param String Project name
      * @param String Theme name
      * @return Array Stylesheets
      **/
      public function getScripts($project, $theme) {
        if($this->doesThemeExist($project, $theme)) { # If the theme exist.
          return $this->DATABASE_CLASS->getScripts($project, $theme);
        } else { # Theme doesn't exist, there is no point of return an empty array
          return null;
        }
      }

      /**
      * Check if a token exist.
      * @param String Project name
      * @param String Theme name
      * @return Boolean Theme exist
      **/
      public function doesTokenExist($project, $token) {
        return $this->DATABASE_CLASS->doesTokenExist($project, $token);
      }

      /**
      * Check if a token is enabled.
      * @param String Project name
      * @param String Theme name
      * @return Boolean Is enabled
      **/
      public function isTokenEnabled($project, $token) {
        if($this->doesTokenExist($project, $token)) { # If the theme exist.
          return $this->DATABASE_CLASS->isTokenEnabled($project, $token);
        } else { # No token, not enabled.
          return null;
        }
      }

      /**
      * Get the theme of a token
      * @param String Project name
      * @param String Token
      * @return String Theme name
      **/
      public function getTokenTheme($project, $token) {
        if($this->doesTokenExist($project, $token)) { # If the theme exist.
          return $this->DATABASE_CLASS->getTokenTheme($project, $token);
        } else { # Theme doesn't exist, there is no point of return an empty array
          return null;
        }
      }
    }
