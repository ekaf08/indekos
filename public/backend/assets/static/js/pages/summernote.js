$(".summernote").summernote({
    tabsize: 2,
    height: 180,
});

// custom summernote
// $(".note-btn-group.note-fontname").remove();
// setTimeout(() => {
//     $(".note-btn-group.note-fontname").remove();
//     $(".note-btn-group.note-view").remove();
//     $(".note-btn-group.note-table").remove();
//     $(".note-btn-group.note-para").remove();
//     $(".note-btn-group.note-color").remove();
//     // $(".note-btn-group.note-style").remove();
//     $(".note-btn-group.note-insert").remove();
//     // $('.note-btn-group.note-insert').remove();
// }, 300);
//End custom summernote

// $(".summernote").summernote({
//     fontNames: [""],
//     height: 300,
//     toolbar: [
//         // [groupName, [list of button]]
//         ["style", ["bold", "italic", "underline", "clear"]],
//         ["font", ["strikethrough", "superscript", "subscript"]],
//         ["fontsize", ["fontsize"]],
//         ["color", ["color"]],
//         ["para", ["ul", "ol", "paragraph"]],
//         ["height", ["height"]],
//         // ['insert', ['link', 'picture', 'video']],
//         ["insert", ["picture"]],
//     ],
//     codeviewFilter: false,
//     codeviewIframeFilter: true,
//     codeviewFilterRegex: "custom-regex",
//     codeviewIframeWhitelistSrc: [
//         "www.youtube.com",
//         "www.youtube-nocookie.com",
//         "www.facebook.com",
//         "vine.co",
//         "instagram.com",
//         "player.vimeo.com",
//         "www.dailymotion.com",
//         "player.youku.com",
//         "v.qq.com",
//     ],
// });

$(".summernote-hint").summernote({
    height: 100,
    toolbar: false,
    placeholder: "type with apple, orange, watermelon and lemon",
    hint: {
        words: ["apple", "orange", "watermelon", "lemon"],
        match: /\b(\w{1,})$/,
        search: function (keyword, callback) {
            callback(
                $.grep(this.words, function (item) {
                    return item.indexOf(keyword) === 0;
                })
            );
        },
    },
});
