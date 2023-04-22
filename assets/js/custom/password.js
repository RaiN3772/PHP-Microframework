"use strict";
var AccountSettings = function () {
    var o, i, s, a, l,
        c = function () {
            o.classList.toggle("d-none"), a.classList.toggle("d-none"), i.classList.toggle("d-none")
        };
    return {
        init: function () {
            o = document.getElementById("signin_password"), i = document.getElementById("signin_password_edit"), a = document.getElementById("signin_password_button"), l = document.getElementById("password_cancel"), ((function () {
            })), a.querySelector("button").addEventListener("click", (function () {
                c()
            })), l.addEventListener("click", (function () {
                c()
            })),
                function () {
                    var n = document.getElementById("signin_change_password");
                    if (n) {
                        var validation = FormValidation.formValidation(n, {
                            fields: {
                                currentpassword: {
                                    validators: {
                                        notEmpty: {
                                            message: "Current Password is required"
                                        }
                                    }
                                },
                                newpassword: {
                                    validators: {
                                        notEmpty: {
                                            message: "New Password is required"
                                        }
                                    }
                                },
                                confirmpassword: {
                                    validators: {
                                        notEmpty: {
                                            message: "Confirm Password is required"
                                        },
                                        identical: {
                                            compare: function () {
                                                return n.querySelector('[name="newpassword"]').value
                                            },
                                            message: "The password and its confirm are not the same"
                                        }
                                    }
                                }
                            },
                            plugins: {
                                trigger: new FormValidation.plugins.Trigger,
                                bootstrap: new FormValidation.plugins.Bootstrap5({
                                    rowSelector: ".fv-row"
                                })
                            }
                        });

                        n.querySelector("#password_submit").addEventListener("click", (function (t) {
                            t.preventDefault(), validation.validate().then((function (t) {
                                "Valid" == t ? swal.fire({
                                    text: "Are you sure you would like to change your password?",
                                    icon: "warning",
                                    showCancelButton: !0,
                                    buttonsStyling: !1,
                                    confirmButtonText: "Yes, change it!",
                                    cancelButtonText: "No, cancel",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary",
                                        cancelButton: "btn fw-bold btn-active-light-primary"
                                    }
                                }).then(function (result) {
                                    if (result.isConfirmed) {
                                        n.submit();
                                    }
                                }) : swal.fire({
                                    text: "Sorry, looks like there are some errors detected, please try again.",
                                    icon: "error",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn font-weight-bold btn-light-primary"
                                    }
                                })
                            }))
                        }))
                    }
                }()
        }
    }
}();
KTUtil.onDOMContentLoaded((function () {
    AccountSettings.init()
}));
