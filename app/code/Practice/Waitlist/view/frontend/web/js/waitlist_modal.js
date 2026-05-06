define([
    'jquery',
    'Magento_Ui/js/modal/modal',
    'mage/url',
    'mage/validation'
], function ($, modal, urlBuilder) {
    'use strict';

    return function (config, element) {
        var options = {
            type: 'popup',
            responsive: true,
            innerScroll: true,
            modalClass: 'waitlist-modal',
            buttons: []
        };
        var popup = modal(options, $('#join-waitlist-modal'));

        $(element).find('#join-waitlist-btn').on('click', function () {
            $('#join-waitlist-modal').modal('openModal');
        });

        // The modal widget moves #join-waitlist-modal to the <body>,
        // safely outside the product add-to-cart form. We can now wrap our fields in a real <form>.
        if (!$('#waitlist-form').length) {
            $('#waitlist-form-content').wrap('<form id="waitlist-form" method="post"></form>');
        }

        var $form = $('#waitlist-form');
        $form.mage('validation', {});

        $form.on('submit', function (e) {
            e.preventDefault();

            if ($form.valid()) {
                $.ajax({
                    url: urlBuilder.build('waitlist/manage/submit'),
                    type: 'POST',
                    data: $form.serialize(),
                    showLoader: true,
                    success: function (response) {
                        if (response.success) {
                            $('#join-waitlist-modal').modal('closeModal');
                            $form[0].reset();
                            require(['Magento_Ui/js/modal/alert'], function (alert) {
                                alert({
                                    title: $.mage.__('Success'),
                                    content: response.message || $.mage.__('You have been successfully added to the waitlist.'),
                                    actions: {
                                        always: function(){}
                                    }
                                });
                            });
                        } else {
                            require(['Magento_Ui/js/modal/alert'], function (alert) {
                                alert({
                                    title: $.mage.__('Error'),
                                    content: response.message || $.mage.__('An error occurred while submitting the waitlist.'),
                                    actions: {
                                        always: function(){}
                                    }
                                });
                            });
                        }
                    },
                    error: function () {
                        require(['Magento_Ui/js/modal/alert'], function (alert) {
                            alert({
                                title: $.mage.__('Error'),
                                content: $.mage.__('An error occurred while submitting the request.'),
                                actions: {
                                    always: function(){}
                                }
                            });
                        });
                    }
                });
            }
        });
    };
});