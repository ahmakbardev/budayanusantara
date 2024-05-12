import "./bootstrap";



import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
// import SourceEditing from '@ckeditor/ckeditor5-source-editing'; // Plugin untuk source editing

// Inisialisasi CKEditor untuk textarea dengan class 'ckeditor'
document.querySelectorAll(".ckeditor").forEach((textarea) => {
    ClassicEditor.create(textarea, {
        // Kustomisasi toolbar
        toolbar: [
            "heading",
            "bold",
            "italic",
            "link",
            "bulletedList",
            "numberedList",
            "blockQuote",
            "insertTable",
            "undo",
            "redo",
        ],
        // Kustomisasi heading untuk mengubah tag dan menambahkan class
        heading: {
            options: [
                {
                    model: "paragraph",
                    view: "p",
                    title: "Paragraph",
                    class: "ck-heading_paragraph",
                },
                {
                    model: "heading1",
                    view: {
                        name: "h1", // Menggunakan tag H1
                        classes: "custom-class-h1 text-3xl font-bold", // Menambahkan class khusus
                    },
                    title: "Heading 1",
                    class: "ck-heading_heading1",
                },
                {
                    model: "heading2",
                    view: {
                        name: "h2", // Menggunakan tag H2
                        classes: "custom-class-h2", // Menambahkan class khusus
                    },
                    title: "Heading 2",
                    class: "ck-heading_heading2",
                },
            ],
        },
        // Konfigurasi untuk upload gambar
        // Plugin tambahan (seperti SourceEditing)
        // extraPlugins: [SourceEditing],
    })
        .then((editor) => {
            textarea.classList.add("ckeditor-initialized");

            console.log("CKEditor initialized");
        })
        .catch((error) => {
            console.error("Error initializing CKEditor:", error);
        });
});

function initializeCKEditor() {
    document.querySelectorAll(".ckeditor").forEach((textarea) => {
        if (!textarea.classList.contains("ckeditor-initialized")) {
            ClassicEditor.create(textarea, {
                toolbar: [
                    "heading",
                    "bold",
                    "italic",
                    "link",
                    "bulletedList",
                    "numberedList",
                    "blockQuote",
                    "insertTable",
                    "undo",
                    "redo",
                ],
                heading: {
                    options: [
                        {
                            model: "paragraph",
                            view: "p",
                            title: "Paragraph",
                            class: "ck-heading_paragraph",
                        },
                        {
                            model: "heading1",
                            view: {
                                name: "h1",
                                classes: "custom-class-h1 text-3xl font-bold",
                            },
                            title: "Heading 1",
                            class: "ck-heading_heading1",
                        },
                        {
                            model: "heading2",
                            view: {
                                name: "h2",
                                classes: "custom-class-h2",
                            },
                            title: "Heading 2",
                            class: "ck-heading_heading2",
                        },
                    ],
                },
            })
                .then((editor) => {
                    textarea.classList.add("ckeditor-initialized");
                })
                .catch((error) => {
                    console.error("Error initializing CKEditor:", error);
                });
        }
    });
}

// Panggil inisialisasi CKEditor setelah Livewire merender ulang
setTimeout(initializeCKEditor, 100);

document.querySelector("[x-data]").addEventListener("click", function () {
    setTimeout(initializeCKEditor, 10);
});

// import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

// document.querySelectorAll(".ckeditor").forEach((textarea) => {
//     ClassicEditor.create(textarea, {
//         toolbar: [
//             "heading",
//             "bold",
//             "italic",
//             "link",
//             "bulletedList",
//             "numberedList",
//             "blockQuote",
//             "insertTable",
//             "undo",
//             "redo",
//             "imageUpload", // Pastikan toolbar untuk upload gambar
//         ],
//     })
//         .then((editor) => {
//             textarea.classList.add("ckeditor-initialized");
//         })
//         .catch((error) => {
//             console.error("Error initializing CKEditor:", error);
//         });
// });

// function initializeCKEditor() {
//     // Inisialisasi CKEditor dengan konfigurasi upload gambar
//     document.querySelectorAll(".ckeditor").forEach((textarea) => {
//         if (!textarea.classList.contains("ckeditor-initialized")) {
//             ClassicEditor.create(textarea, {
//                 toolbar: [
//                     "heading",
//                     "bold",
//                     "italic",
//                     "link",
//                     "bulletedList",
//                     "numberedList",
//                     "blockQuote",
//                     "insertTable",
//                     "undo",
//                     "redo",
//                     "imageUpload", // Pastikan opsi upload gambar tersedia
//                 ],
//             })
//                 .then((editor) => {
//                     textarea.classList.add("ckeditor-initialized");
//                 })
//                 .catch((error) => {
//                     console.error("Error initializing CKEditor:", error);
//                 });
//         }
//     });
// }

// // Panggil inisialisasi CKEditor setelah Livewire merender ulang
// setTimeout(initializeCKEditor, 100); // Penundaan untuk memastikan Livewire selesai dirender

// document.querySelector("[x-data]").addEventListener("click", function () {
//     setTimeout(initializeCKEditor, 10); // Penundaan untuk memastikan event selesai
// });
