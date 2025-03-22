<?php
return [
    'page' => [
        'title' => 'Text Compare',
        'description' => 'Compare and analyze differences between two texts.'
    ],
    'input' => [
        'text1_label' => 'First Text',
        'text2_label' => 'Second Text',
        'text1_placeholder' => 'Enter or paste your first text here...',
        'text2_placeholder' => 'Enter or paste your second text here...'
    ],
    'buttons' => [
        'compare' => 'Compare',
        'clear' => 'Clear',
        'copy_result' => 'Copy Result',
        'swap' => 'Swap Texts'
    ],
    'results' => [
        'title' => 'Comparison Results',
        'differences_found' => 'Differences found: {count}',
        'no_differences' => 'No differences found.',
        'identical_texts' => 'The texts are identical.',
        'added' => 'Added',
        'removed' => 'Removed',
        'modified' => 'Modified'
    ],
    'options' => [
        'title' => 'Comparison Options',
        'ignore_case' => 'Ignore Case',
        'ignore_whitespace' => 'Ignore Whitespace',
        'ignore_punctuation' => 'Ignore Punctuation'
    ],
    'help' => [
        'title' => 'Help',
        'description' => 'How to use this tool',
        'steps' => [
            '1' => '1. Enter or paste the two texts you want to compare in the input boxes.',
            '2' => '2. Select any comparison options you need.',
            '3' => '3. Click the "Compare" button.',
            '4' => '4. View the results with highlighted differences.'
        ]
    ],
    'errors' => [
        'empty_input' => 'Please enter both texts to compare.',
        'same_text' => 'The texts are identical.',
        'too_long' => 'Text is too long. (Maximum 100,000 characters)'
    ]
]; 