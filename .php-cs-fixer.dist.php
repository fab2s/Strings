<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude('vendor')
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);
$config = new PhpCsFixer\Config();

$header = <<<'EOF'
This file is part of Strings
    (c) Fabrice de Stefanis / https://github.com/fab2s/Strings
This source file is licensed under the MIT license which you will
find in the LICENSE file or at https://opensource.org/licenses/MIT
EOF;

return $config
    ->setUsingCache(true)
    ->setRules([
        'header_comment' => ['header' => $header],
        'array_syntax'                                  => ['syntax' => 'short'],
        'binary_operator_spaces'                        => [
            'default' => 'align_single_space',
        ],
        'blank_line_after_namespace'                    => true,
        'blank_line_after_opening_tag'                  => true,
        'blank_line_before_statement'                   => [
            'statements' => ['return'],
        ],
        'braces'                                        => true,
        'cast_spaces'                                   => true,
        'combine_consecutive_unsets'                    => true,
        'class_attributes_separation'                   => [
            'elements' => ['const' => 'only_if_meta', 'trait_import' => 'one', 'property' => 'only_if_meta'],
        ],
        'class_definition'                              => true,
        'concat_space'                                  => [
            'spacing' => 'one',
        ],
        'declare_equal_normalize'                       => true,
        'elseif'                                        => true,
        'encoding'                                      => true,
        'full_opening_tag'                              => true,
        'fully_qualified_strict_types'                  => true,
        'function_declaration'                          => true,
        'function_typehint_space'                       => true,
        'heredoc_to_nowdoc'                             => true,
        'include'                                       => true,
        'increment_style'                               => ['style' => 'pre'],
        'indentation_type'                              => true,
        'linebreak_after_opening_tag'                   => true,
        'line_ending'                                   => true,
        'lowercase_cast'                                => true,
        'constant_case'                                 => ['case' => 'lower'],
        'lowercase_keywords'                            => true,
        'lowercase_static_reference'                    => true,
        'magic_method_casing'                           => true,
        'magic_constant_casing'                         => true,
        'method_argument_space'                         => true,
        'multiline_whitespace_before_semicolons'        => [
            'strategy' => 'no_multi_line',
        ],
        'native_function_casing'                        => true,
        'no_extra_blank_lines'                          => [
            'tokens' => [
                'extra',
                'throw',
                'use',
            ],
        ],
        'no_blank_lines_after_class_opening'            => true,
        'no_blank_lines_after_phpdoc'                   => true,
        'no_closing_tag'                                => true,
        'no_empty_phpdoc'                               => true,
        'no_empty_statement'                            => true,
        'no_leading_import_slash'                       => true,
        'no_leading_namespace_whitespace'               => true,
        'no_mixed_echo_print'                           => [
            'use' => 'echo',
        ],
        'no_multiline_whitespace_around_double_arrow'   => true,
        'multiline_whitespace_before_semicolons'        => true,
        'no_short_bool_cast'                            => true,
        'no_singleline_whitespace_before_semicolons'    => true,
        'no_spaces_after_function_name'                 => true,
        'no_spaces_around_offset'                       => true,
        'no_spaces_inside_parenthesis'                  => true,
        'no_trailing_comma_in_singleline'               => true,
        'no_trailing_whitespace'                        => true,
        'no_trailing_whitespace_in_comment'             => true,
        'no_unneeded_control_parentheses'               => true,
        'no_unneeded_curly_braces'                      => true,
        'no_useless_else'                               => true,
        'no_useless_return'                             => true,
        'no_whitespace_before_comma_in_array'           => true,
        'no_whitespace_in_blank_line'                   => true,
        'normalize_index_brace'                         => true,
        'object_operator_without_whitespace'            => true,
        'ordered_class_elements'                        => true,
        'ordered_imports'                               => ['sort_algorithm' => 'alpha'],
        'php_unit_fqcn_annotation'                      => true,
        'phpdoc_add_missing_param_annotation'           => true,
        'phpdoc_align'                                  => true,
        'phpdoc_indent'                                 => true,
        'phpdoc_annotation_without_dot'                 => true,
        'phpdoc_inline_tag_normalizer'                  => true,
        'phpdoc_no_alias_tag'                           => true,
        'general_phpdoc_tag_rename'                     => true,
        'phpdoc_no_empty_return'                        => true,
        'phpdoc_tag_type'                               => true,
        'phpdoc_no_access'                              => true,
        'phpdoc_no_package'                             => true,
        'phpdoc_no_useless_inheritdoc'                  => true,
        'phpdoc_order'                                  => true,
        'phpdoc_scalar'                                 => true,
        'phpdoc_separation'                             => true,
        'phpdoc_single_line_var_spacing'                => true,
        'phpdoc_to_comment'                             => true,
        'phpdoc_summary'                                => false,
        'phpdoc_trim'                                   => true,
        'phpdoc_types'                                  => true,
        'phpdoc_var_without_name'                       => true,
        'semicolon_after_instruction'                   => true,
        'single_blank_line_at_eof'                      => true,
        'single_blank_line_before_namespace'            => true,
        'single_class_element_per_statement'            => true,
        'single_import_per_statement'                   => true,
        'no_unused_imports'                             => true,
        'single_line_after_imports'                     => true,
        'single_line_comment_style'                     => [
            'comment_types' => ['hash'],
        ],
        'single_quote'                                  => true,
        'space_after_semicolon'                         => true,
        'standardize_not_equals'                        => true,
        'switch_case_semicolon_to_colon'                => true,
        'switch_case_space'                             => true,
        'ternary_operator_spaces'                       => true,
        'trailing_comma_in_multiline'                   => [
            'elements' => ['arrays']
        ],
        'trim_array_spaces'                             => true,
        'unary_operator_spaces'                         => true,
        'visibility_required'                           => [
            'elements' => ['method', 'property'],
        ],
        'whitespace_after_comma_in_array'               => true,
    ])
    ->setFinder($finder);
