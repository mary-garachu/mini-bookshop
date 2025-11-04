<?php
/**
 * Script to import books from CSV
 */

function mb_import_books_from_csv() {
    $csv_file = get_stylesheet_directory() . '/books.csv';

    if (!file_exists($csv_file)) {
        wp_die('CSV file not found at: ' . $csv_file);
    }

    $handle = fopen($csv_file, 'r');
    if ($handle === false) {
        wp_die('Unable to open CSV file.');
    }

    $row = 0;
    while (($data = fgetcsv($handle, 1000, ',')) !== false) {
        if ($row === 0) { $row++; continue; }

        $book_title = sanitize_text_field($data[0]);
        $author     = sanitize_text_field($data[1]);
        $isbn       = sanitize_text_field($data[2]);
        $price      = sanitize_text_field($data[3]);

        // Skip if book already exists
        $existing_book = get_page_by_title($book_title, OBJECT, 'book');
        if ($existing_book) { continue; }

        // Create new Book post
        $book_id = wp_insert_post([
            'post_title'   => $book_title,
            'post_type'    => 'book',
            'post_status'  => 'publish',
            'post_content' => '',
        ]);

        if (!is_wp_error($book_id)) {
            // Fill ACF fields
            update_field('author', $author, $book_id);
            update_field('isbn', $isbn, $book_id);
            update_field('price', $price, $book_id);
        }
    }

    fclose($handle);
    echo '✅ Books imported successfully!';
    exit;
}

// Trigger import via URL
add_action('init', function() {
    if (isset($_GET['import_books']) && $_GET['import_books'] == 1) {
        mb_import_books_from_csv();
    }
});
