# Split Image

Split Image is a tool written in PHP to split images in format of PNG to smaller pieces. What is more valuable it could be used to split images with repetition of the left/right top/bottom fragments to get atlas form of presentation.

# Installation

    composer require drezynsoft/split-image

or simply download the package in zip format.

# Configuration

You can use the `config/config.php` file or just override default options with args in console.

## `config/config.php` options

## Params obliged:

### After split command: `source-file`
Path to PNG file to split.

### After source-file: `destination-dir` (second after split command)
Path to directory where split files will be saved.

> Note: Minimal command is as follows (warning: last slash is required):

`$ split-image split path/to/png/file.png path/to/save-dir/`

> Note: Trailing slash in directory path is necessary.

## List of other available params:

### `--width` default: 2200 (int)
Destination width [px] of the every split image.

### `--height` default: 3300 (int)
Destination height [px] of the every split image.

### `--left-right-margin` default: 500 (int)
Margin of the previous (if any) split image. It is the simply floating coat of the previous split image (in width) [px].

### `--top-bottom-margin` default: 500 (int)
Margin of the previous (if any) split image. It is the simply floating coat of the previous split image (in height) [px].

### `--sep` default: '_' (string)
Text between digits of rows count and cols count.

### `--prefix` default: '' (string)
Text before digits of rows and cols.

### `--suffix` default: '' (string)
Text after digits of rows and cols.

### `--RAM-factor` default: 3.0 (float)
Multiplier for calculating predicted RAM usage.

### `--compression` default: 0 max: 9 (int)
Compression of PNG file 0-9.

> Note: All params starting with `--` are optional and could be given in any order.
> Also all of them can be used in `config/config.php` without the `--` prefix.

## List of params outside of the console:

### `default-file` default: 'data/to_convert/DrezynSoft.png' (string)
Source file.

### `default-dir` default: 'data/converted/' (string)
Destination directory.

# Usage

## Simplest usage (with defaults)

### By console

`$ vendor/bin/split-image split path/to/png/file.png path/to/save-dir/`

or without composer

`$ scripts/split-image split path/to/png/file.png path/to/save-dir/`

> Note: Trailing slash in directory path is necessary.

> Tip: When params in `config/config.php` are the same you would like to use, you don't have to pass them into console command. The params will be get from config file.

### By http

go to:
http://example.com/split-image/

> Note: With assumption that tool is installed in split-image dir in public of the site.

> Recommendation: When you use huge files it can take long to split so end of script execution could interrupt the process.

> Note: There is no possible to change defaults options. You can only edit the `config/config.php` and then open the http page.

# Issues

The tool has been made for one reason at one moment so we really can not to predict new version of this program.