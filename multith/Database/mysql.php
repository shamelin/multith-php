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

    # MySQL interface for Multith.
    # Get info from the database with only one method.
    class mysql implements DatabaseType {
      protected $DATABASE = null;
      protected $SETTINGS = null;

      /**
      * Initiate the connection to the database.
      * @param Multith Connection arguments
      **/
      public function __construct($settings) {
        try {
          $this->DATABASE = new PDO("mysql:hostname=" . $settings->DATABASE_HOST . ";dbname=" . $settings->DATABASE_NAME . ";port=" . $settings->DATABASE_PORT, $settings->DATABASE_USER, $settings->DATABASE_PASS);
        } catch(PDOException $e) {
          throw new Exception($e->getMessage());
        }
      }

      /**
      * Get the database
      * @return PDO Database
      **/
      private function getDatabase() {
        return $this->DATABASE;
      }

      /**
      * Get the default theme name of a project.
      * @return String Project name
      **/
      public function getDefaultThemeName($project) {
        foreach($this->getDatabase()->query("SELECT * FROM multith_projects WHERE name='" . $project . "'") as $row) {
          return $row['default_theme'];
        }

        return null;
      }

      /**
      * Check if a theme exist in a project.
      * @param String Project name
      * @param String Theme name
      * @return Boolean Theme exist
      **/
      public function doesThemeExist($project, $theme) {
        foreach($this->getDatabase()->query("SELECT * FROM multith_themes WHERE project='" . $project . "' AND theme='" . $theme . "'") as $row) { # Search for theme in database
          return true; # Found!
        }

        return false; # Not found...
      }

      /**
      * Check if a project exist.
      * @param String Project name
      * @return Boolean Project exist
      **/
      public function doesProjectExist($project) {
        foreach($this->getDatabase()->query("SELECT * FROM multith_projects WHERE name='" . $project . "'") as $row) { # Search for project in database
          return true; # Found!
        }

        return false; # Not found...
      }

      /**
      * Check if a theme is enabled.
      * @param String Project name
      * @param String Theme name
      * @return Boolean Is enabled
      **/
      public function isThemeEnabled($project, $theme) {
        foreach($this->getDatabase()->query("SELECT * FROM multith_themes WHERE project='" . $project . "' AND theme='" . $theme . "'") as $row) { # For each theme of a project
          if($row['enabled'] == true) { # If theme is enabled
            return true;
          }
        }

        return false;
      }

      /**
      * Get the stylesheets of a theme.
      * @param String Project name
      * @param String Theme name
      * @return Array Stylesheets
      **/
      public function getStylesheets($project, $theme) {
        $stylesheets = array();

        foreach($this->getDatabase()->query("SELECT * FROM multith_themes WHERE project='" . $project . "' AND theme='" . $theme . "'") as $row) { # Get the theme
          $stylesheets_exploded = explode(';', $row['stylesheets']);

          for($i = 0 ; $i < count($stylesheets_exploded) ; $i++) {
            array_push($stylesheets, $stylesheets_exploded[$i]);
          }
        }

        return $stylesheets;
      }

      /**
      * Get the scripts of a theme.
      * @param String Project name
      * @param String Theme name
      * @return Array Stylesheets
      **/
      public function getScripts($project, $theme) {
        $scripts = array();

        foreach($this->getDatabase()->query("SELECT * FROM multith_themes WHERE project='" . $project . "' AND theme='" . $theme . "'") as $row) { # Get the theme
          $scripts_expoded = explode(';', $row['scripts']);

          for($i = 0 ; $i < count($scripts_expoded) ; $i++) {
            array_push($scripts, $scripts_expoded[$i]);
          }
        }

        return $scripts;
      }

      /**
      * Check if a token exist.
      * @param String Project name
      * @param String Theme name
      * @return Boolean Theme exist
      **/
      public function doesTokenExist($project, $token) {
        foreach($this->getDatabase()->query("SELECT * FROM multith_tokens WHERE project='" . $project . "' AND token='" . $token . "'") as $row) { # Check for token in database
          return true; # Found!
        }

        return false; # Not found...
      }

      /**
      * Check if a token is enabled.
      * @param String Project name
      * @param String Theme name
      * @return Boolean Is enabled
      **/
      public function isTokenEnabled($project, $token) {
        foreach($this->getDatabase()->query("SELECT * FROM multith_tokens WHERE project='" . $project . "' AND token='" . $token . "'") as $row) { # For each theme of a project
          if($row['enabled'] == true) { # If token is enabled
            return true;
          }
        }

        return false;
      }

      /**
      * Get the theme of a token.
      * @param String Project name
      * @param String Token
      * @return String Theme name
      **/
      public function getTokenTheme($project, $token) {
        foreach($this->getDatabase()->query("SELECT * FROM multith_tokens WHERE project='" . $project . "' AND token='" . $token . "'") as $row) { # For each theme of a project
          return $row['theme'];
        }

        return null;
      }
    }
