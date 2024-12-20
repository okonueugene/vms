$(function () {
    let country_code_name = localStorage.getItem('country_code_name');

    $("#number").intlTelInput({
        autoHideDialCode: true,
        autoPlaceholder: "ON",
        dropdownContainer: document.body,
        formatOnDisplay: true,
        initialCountry: country_code_name ? country_code_name : "us",
        placeholderNumberType: "MOBILE",
        preferredCountries: ["us", "gb", "in"],
        separateDialCode: true,
    });

    localStorage.setItem('country_code_name', '');
});

$("#number").on("countrychange", function (e, countryData) {
    var code = $("#number").intlTelInput("getSelectedCountryData").dialCode;
    $("#code").val(code);
    var code_name = $("#number").intlTelInput("getSelectedCountryData").iso2;
    $("#code_name").val(code_name);
});
