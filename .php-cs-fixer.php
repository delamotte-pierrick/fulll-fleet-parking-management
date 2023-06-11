<?php
/*
 * This document has been generated with
 * https://mlocati.github.io/php-cs-fixer-configurator/#version:3.13.2|configurator
 * you can change this configuration by importing this file.
 */
$config = new PhpCsFixer\Config();
return $config
    ->setRules([
        'blank_line_after_namespace' => true,
        'blank_line_after_opening_tag' => true,
        'blank_line_between_import_groups' => true,
        'braces' => true,
        'class_definition' => true,
        'compact_nullable_typehint' => true,
        'constant_case' => true,
        'declare_equal_normalize' => true,
        'elseif' => true,
        'encoding' => true,
        'full_opening_tag' => true,
        'function_declaration' => true,
        'indentation_type' => true,
        'line_ending' => true,
        'lowercase_cast' => true,
        'lowercase_keywords' => true,
        'lowercase_static_reference' => true,
        'method_argument_space' => true,
        'new_with_braces' => true,
        'no_blank_lines_after_class_opening' => true,
        'no_break_comment' => true,
        'no_closing_tag' => true,
        'no_leading_import_slash' => true,
        'no_space_around_double_colon' => true,
        'no_spaces_after_function_name' => true,
        'no_spaces_inside_parenthesis' => true,
        'no_trailing_whitespace' => true,
        'no_trailing_whitespace_in_comment' => true,
        'no_whitespace_in_blank_line' => true,
        'ordered_class_elements' => true,
        'ordered_imports' => false,
        'return_type_declaration' => true,
        'short_scalar_cast' => true,
        'single_blank_line_at_eof' => true,
        'single_blank_line_before_namespace' => true,
        'single_class_element_per_statement' => true,
        'single_import_per_statement' => true,
        'single_line_after_imports' => true,
        'single_trait_insert_per_statement' => true,
        'switch_case_semicolon_to_colon' => true,
        'switch_case_space' => true,
        'ternary_operator_spaces' => true,
        'visibility_required' => true,
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()
        // ->exclude('folder-to-exclude') // if you want to exclude some folders, you can do it like this!
        ->in(__DIR__)
    )
;
