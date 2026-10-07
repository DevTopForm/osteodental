
    // Namespace-safe FeedbackForm object

    var FeedbackForm = {
        init: function () {
            // Delegated click on submit button inside feedback-form
            document.addEventListener('click', function (e) {
                var btn = e.target.closest('.popup__form-submit');
                if (!btn) return;
                var form = btn.closest('form.feedback-form');
                if (!form) return;
                e.preventDefault();
                FeedbackForm.submit(form, btn);
            });

            // Also handle form submit if user presses Enter
            document.addEventListener('submit', function (e) {
                var form = e.target;
                if (!(form && form.classList && form.classList.contains('feedback-form'))) return;
                e.preventDefault();
                FeedbackForm.submit(form);
            }, true);
        },

        setBusy: function (el, busy) {
            if (!el) return;
            if (busy) {
                el.setAttribute('disabled', 'disabled');
                el.classList.add('is-loading');
            } else {
                el.removeAttribute('disabled');
                el.classList.remove('is-loading');
            }
        },

        showMessage: function (form, msg, type) {
            var box = form.querySelector('.form-result');
            if (!box) {
                box = document.createElement('div');
                box.className = 'form-result';
                form.prepend(box);
            }
            box.innerHTML = msg;
            box.classList.remove('is-error', 'is-success');
            box.classList.add(type === 'error' ? 'is-error' : 'is-success');
        },

        validate: function (form) {
            // Consent checkbox is identified by label class .feedback-form__agreed
            var label = form.querySelector('.feedback-form__agreed');
            var agreed = label ? label.querySelector('input[type="checkbox"]') : null;
            if (agreed && !agreed.checked) {
                var lbl = agreed.closest('label');
                if (lbl) {
                    lbl.classList.add('mistake');
                }
                FeedbackForm.showMessage(form, "Поставьте отметку согласия на обработку персональных данных", 'error');
                return false;
            }
            // remove previous mistake on consent if checked
            if (agreed && agreed.checked) {
                var lbl2 = agreed.closest('label');
                if (lbl2) {
                    lbl2.classList.remove('mistake');
                }
            }
            return true;
        },

        submit: function (form, triggerBtn) {
            if (!FeedbackForm.validate(form)) return;

            var action = form.getAttribute('action') || window.location.href;
            var method = (form.getAttribute('method') || 'post').toUpperCase();
            var fd = new FormData(form);
            var cID = '';

            ym(107154300, 'getClientID', function (clientID) {
                cID = clientID;
            });

            fd.append('clientID', cID);

            FeedbackForm.setBusy(triggerBtn || form.querySelector('.popup__form-submit'), true);

            fetch(action, {
                method: method,
                body: fd,
                headers: {'X-Requested-With': 'XMLHttpRequest'},
                credentials: 'same-origin'
            }).then(function (res) {
                var ct = res.headers.get('content-type') || '';
                if (ct.indexOf('application/json') !== -1) {
                    return res.json();
                }
                return res.text();
            }).then(function (data) {
                if (typeof data === 'object' && data) {
                    // Backend returns {status: boolean, message?: string, errors?: string[]}
                    var ok = !!data.status;
                    // Clear previous field errors
                    Array.prototype.forEach.call(form.querySelectorAll('.label.mistake'), function (lbl) {
                        lbl.classList.remove('mistake');
                    });
                    if (ok) {
                        FeedbackForm.showMessage(form, data.message || "Спасибо. Ваша заявка отправлена.", 'success');
                        ym(107154300, 'reachGoal', 'ORDER');
                        form.reset();
                    } else {
                        let errors = [];
                        // Mark fields with errors on their labels
                        if (Array.isArray(data.errors)) {
                            data.errors.forEach(function (error) {
                                errors.push(error.html);
                            });
                        }
                        FeedbackForm.showMessage(form, data.message || errors.join(''), 'error');
                    }
                } else {
                    FeedbackForm.showMessage(form, "Спасибо. Ваша заявка отправлена.", 'success');
                    form.reset();
                }
            }).catch(function (err) {
                FeedbackForm.showMessage(form, "Ошибка сети" + (err && err.message ? err.message : "Неизвестная ошибка"), 'error');
            }).finally(function () {
                FeedbackForm.setBusy(triggerBtn || form.querySelector('.popup__form-submit'), false);
            });
        }
    };

    // Expose and init
    window.FeedbackForm = FeedbackForm;
    FeedbackForm.init();