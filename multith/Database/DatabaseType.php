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

    # Interface for the database type classes.
    #
    # DO NOT MODIFY. MODIFYING INFORMATIONS IN THIS FILE MAY RESULT
    # IN A CRASH OF THE SCRIPT.
    interface DatabaseType {
      /**
      * Get the default theme name of a project.
      * @return String Project name
      **/
      public function getDefaultThemeName($project);

      /**
      * Check if a theme exist in a project.
      * @param String Project name
      * @param String Theme name
      * @return Boolean Theme exist
      **/
      public function doesThemeExist($project, $theme);

      /**
      * Check if a project exist.
      * @param String Project name
      * @param String Theme name
      * @return Boolean Theme exist
      **/
      public function doesProjectExist($project);

      /**
      * Check if a theme is enabled.
      * @param String Project name
      * @param String Theme name
      * @return Boolean Theme exist
      **/
      public function isThemeEnabled($project, $theme);

      /**
      * Get the stylesheets of a theme.
      * @param String Project name
      * @param String Theme name
      * @return Array Stylesheets
      **/
      public function getStylesheets($project, $theme);

      /**
      * Get the scripts of a theme.
      * @param String Project name
      * @param String Theme name
      * @return Array Stylesheets
      **/
      public function getScripts($project, $theme);

      /**
      * Check if a token exist.
      * @param String Project name
      * @param String Theme name
      * @return Boolean Theme exist
      **/
      public function doesTokenExist($project, $token);

      /**
      * Check if a token is enabled.
      * @param String Project name
      * @param String Theme name
      * @return Boolean Is enabled
      **/
      public function isTokenEnabled($project, $token);

      /**
      * Get the theme of a token.
      * @param String Project name
      * @param String Token
      * @return String Theme name
      **/
      public function getTokenTheme($project, $token);
    }
