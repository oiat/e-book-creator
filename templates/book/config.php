book:
    title:            "<?php echo $book_title;?>"
    subtitle:         "<?php echo $book_subtitle;?>"
    author:           "<?php echo $book_author;?>"
    edition:          "<?php echo $book_edition;?>"
    language:         de
    publication_date: ~

    generator: { name: easybook, version: 5.0-DEV }

    contents:
        # available content types: acknowledgement, afterword, appendix, author,
        # chapter, conclusion, cover, dedication, edition, epilogue, foreword,
        # glossary, introduction, license, lof (list of figures), lot (list of
        # tables), part, preface, prologue, title, toc (table of contents)
<?php echo $book_contents;?>

    editions:
        ebook:
            format:         epub
            highlight_code: false
            include_styles: true
<?php echo $book_labels;?>
            theme:          clean
            toc:
                deep:       1
                elements:   ["appendix", "chapter", "part"]

        kindle:
            extends:        ebook
            format:         mobi

        print:
            format:         pdf
            highlight_code: true
            include_styles: true
            isbn:           ~
<?php echo $book_labels;?>
            margin:
                top:        25mm
                bottom:     25mm
                inner:      30mm
                outer:      20mm
            page_size:      A4
            theme:          clean
            toc:
                deep:       1
                elements:   ["appendix", "chapter", "part"]
            two_sided:      false

        web:
            format:         html
            highlight_code: true
            include_styles: true
<?php echo $book_labels;?>
            theme:          clean
            toc:
                deep:       1
                elements:   ["appendix", "chapter"]

        website:
            extends:        web
            format:         html
                            