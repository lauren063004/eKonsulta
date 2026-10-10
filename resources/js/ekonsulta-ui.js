document.addEventListener('DOMContentLoaded', () => {
    const passwordResetForm = document.querySelector('[data-password-reset-form]');

    if (passwordResetForm instanceof HTMLFormElement) {
        const passwordInput = passwordResetForm.querySelector('[data-password-rule-input]');
        const confirmationInput = passwordResetForm.querySelector('[data-password-confirmation]');
        const matchStatus = passwordResetForm.querySelector('[data-password-match-status]');

        if (
            passwordInput instanceof HTMLInputElement
            && confirmationInput instanceof HTMLInputElement
            && matchStatus instanceof HTMLElement
        ) {
            const updatePasswordFeedback = () => {
                const password = passwordInput.value;
                const checks = {
                    length: password.length >= 8,
                    uppercase: /[A-Z]/.test(password),
                    lowercase: /[a-z]/.test(password),
                    number: /\d/.test(password),
                };

                Object.entries(checks).forEach(([rule, passed]) => {
                    const item = passwordResetForm.querySelector(`[data-password-rule="${rule}"]`);

                    if (item instanceof HTMLElement) {
                        item.classList.toggle('is-met', passed);
                    }
                });

                const passwordsMatch = confirmationInput.value.length > 0
                    && password === confirmationInput.value;
                const hasConfirmation = confirmationInput.value.length > 0;

                matchStatus.textContent = !hasConfirmation
                    ? 'Re-enter your new password to confirm it.'
                    : passwordsMatch
                        ? 'Passwords match.'
                        : 'Passwords do not match.';
                matchStatus.classList.toggle('is-match', passwordsMatch);
                matchStatus.classList.toggle('is-mismatch', hasConfirmation && !passwordsMatch);
                confirmationInput.setAttribute('aria-invalid', String(hasConfirmation && !passwordsMatch));
            };

            passwordInput.addEventListener('input', updatePasswordFeedback);
            confirmationInput.addEventListener('input', updatePasswordFeedback);
            updatePasswordFeedback();
        }
    }

    document.querySelectorAll('[data-list-search-input]').forEach((input) => {
        if (!(input instanceof HTMLInputElement)) {
            return;
        }

        const targetId = input.dataset.listSearchTarget;
        const list = targetId ? document.getElementById(targetId) : null;
        const status = input.closest('.list-search')?.querySelector('[data-list-search-status]');

        if (!(list instanceof HTMLElement) || !(status instanceof HTMLElement)) {
            console.error('List search is missing its target list or status message.');
            return;
        }

        const items = Array.from(list.querySelectorAll('[data-search-item]'));

        input.addEventListener('input', () => {
            const query = input.value.trim().toLocaleLowerCase();
            let visibleCount = 0;

            items.forEach((item) => {
                const searchableText = item.textContent?.toLocaleLowerCase() || '';
                const matches = searchableText.includes(query);
                item.hidden = !matches;

                if (matches) {
                    visibleCount += 1;
                }
            });

            list.querySelectorAll('[data-search-group]').forEach((group) => {
                const hasVisibleItems = Array.from(
                    group.querySelectorAll('[data-search-item]')
                ).some((item) => !item.hidden);

                group.hidden = query.length > 0 && !hasVisibleItems;
            });

            status.hidden = query.length === 0 || visibleCount > 0;
        });
    });

    const userMenu = document.getElementById('userMenu');
    const userButton = document.getElementById('userMenuButton');
    const userDropdown = document.getElementById('userDropdown');

    if (userMenu && userButton && userDropdown) {
        userButton.addEventListener('click', (event) => {
            event.stopPropagation();

            const isOpen = userMenu.classList.toggle('open');

            userButton.setAttribute(
                'aria-expanded',
                isOpen ? 'true' : 'false'
            );
        });

        document.addEventListener('click', (event) => {
            if (!userMenu.contains(event.target)) {
                userMenu.classList.remove('open');
                userButton.setAttribute('aria-expanded', 'false');
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                userMenu.classList.remove('open');
                userButton.setAttribute('aria-expanded', 'false');
            }
        });
    }

    const sidebar = document.getElementById('sidebar');
    const menuToggle = document.getElementById('menuToggle');
    const sidebarBackdrop = document.getElementById('sidebarBackdrop');

    if (sidebar && menuToggle && sidebarBackdrop) {
        const setSidebarOpen = (open) => {
            sidebar.classList.toggle('open', open);
            menuToggle.setAttribute('aria-expanded', String(open));
            menuToggle.setAttribute(
                'aria-label',
                open ? 'Close navigation menu' : 'Open navigation menu'
            );
            sidebarBackdrop.setAttribute('aria-hidden', String(!open));
            document.body.classList.toggle('sidebar-open', open);
        };

        menuToggle.addEventListener('click', () => {
            setSidebarOpen(!sidebar.classList.contains('open'));
        });

        sidebarBackdrop.addEventListener('click', () => setSidebarOpen(false));

        sidebar.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => setSidebarOpen(false));
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && sidebar.classList.contains('open')) {
                setSidebarOpen(false);
                menuToggle.focus();
            }
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth > 991 && sidebar.classList.contains('open')) {
                setSidebarOpen(false);
            }
        });
    }

    const imagePreviewModal = document.getElementById('imagePreviewModal');
    const imagePreviewImage = document.getElementById('imagePreviewModalImage');
    const imagePreviewCaption = document.getElementById('imagePreviewModalCaption');
    let imagePreviewTrigger = null;

    if (
        imagePreviewModal instanceof HTMLDialogElement
        && imagePreviewImage instanceof HTMLImageElement
        && imagePreviewCaption instanceof HTMLElement
    ) {
        document.addEventListener('click', (event) => {
            const target = event.target;
            const trigger = target instanceof Element
                ? target.closest('[data-image-preview]')
                : null;

            if (!(trigger instanceof HTMLElement) || !trigger.dataset.imagePreview) {
                return;
            }

            imagePreviewTrigger = trigger;
            imagePreviewImage.src = trigger.dataset.imagePreview;
            imagePreviewImage.alt = trigger.dataset.imageAlt || '';
            imagePreviewCaption.textContent = trigger.dataset.imageAlt || '';
            imagePreviewModal.showModal();
        });

        imagePreviewModal.querySelector('[data-image-preview-close]')?.addEventListener('click', () => {
            imagePreviewModal.close();
        });

        imagePreviewModal.addEventListener('click', (event) => {
            if (event.target === imagePreviewModal) {
                imagePreviewModal.close();
            }
        });

        imagePreviewModal.addEventListener('close', () => {
            imagePreviewImage.removeAttribute('src');
            imagePreviewCaption.textContent = '';
            imagePreviewTrigger?.focus();
            imagePreviewTrigger = null;
        });
    }

    document.querySelectorAll('input[type="file"][name="image"]').forEach((input) => {
        const preview = input.closest('.form-field')?.querySelector('[data-upload-preview]');
        const previewButton = preview?.querySelector('[data-image-preview]');
        const previewImage = previewButton?.querySelector('img');

        if (
            !(input instanceof HTMLInputElement)
            || !(preview instanceof HTMLElement)
            || !(previewButton instanceof HTMLElement)
            || !(previewImage instanceof HTMLImageElement)
        ) {
            return;
        }

        let objectUrl = null;

        input.addEventListener('change', () => {
            if (objectUrl) {
                URL.revokeObjectURL(objectUrl);
                objectUrl = null;
            }

            const file = input.files?.[0];
            if (!file) {
                preview.hidden = true;
                previewImage.removeAttribute('src');
                previewButton.dataset.imagePreview = '';
                return;
            }

            if (!file.type.startsWith('image/')) {
                preview.hidden = true;
                previewImage.removeAttribute('src');
                previewButton.dataset.imagePreview = '';
                return;
            }

            objectUrl = URL.createObjectURL(file);
            previewImage.src = objectUrl;
            previewButton.dataset.imagePreview = objectUrl;
            previewButton.dataset.imageAlt = file.name;
            previewImage.alt = file.name;
            preview.hidden = false;
        });

        window.addEventListener('beforeunload', () => {
            if (objectUrl) {
                URL.revokeObjectURL(objectUrl);
            }
        }, { once: true });
    });

    const confirmationModal = document.getElementById('confirmModal');
    const confirmationTitle = document.getElementById('confirmTitle');
    const confirmationMessage = document.getElementById('confirmMessage');
    const confirmationCancel = document.getElementById('confirmCancel');
    const confirmationOk = document.getElementById('confirmOk');
    let pendingConfirmationForm = null;
    const confirmedForms = new WeakSet();

    if (
        confirmationModal instanceof HTMLElement
        && confirmationTitle instanceof HTMLElement
        && confirmationMessage instanceof HTMLElement
        && confirmationCancel instanceof HTMLButtonElement
        && confirmationOk instanceof HTMLButtonElement
    ) {
        const closeConfirmation = () => {
            confirmationModal.hidden = true;
            document.body.classList.remove('confirmation-open');
            pendingConfirmationForm = null;
        };

        document.addEventListener('submit', (event) => {
            const form = event.target;
            if (!(form instanceof HTMLFormElement) || !form.hasAttribute('data-confirm')) {
                return;
            }

            if (confirmedForms.has(form)) {
                confirmedForms.delete(form);
                return;
            }

            event.preventDefault();
            pendingConfirmationForm = form;
            confirmationTitle.textContent = form.dataset.confirmTitle || 'Are you sure?';
            confirmationMessage.textContent = form.dataset.confirm || 'Please confirm this action.';
            confirmationCancel.textContent = form.dataset.confirmCancel || 'Cancel';
            confirmationOk.textContent = form.dataset.confirmOk || 'Confirm';
            confirmationModal.hidden = false;
            document.body.classList.add('confirmation-open');
            confirmationCancel.focus();
        });

        confirmationCancel.addEventListener('click', closeConfirmation);
        confirmationModal.addEventListener('click', (event) => {
            if (event.target === confirmationModal) {
                closeConfirmation();
            }
        });

        confirmationOk.addEventListener('click', () => {
            if (!pendingConfirmationForm) {
                return;
            }

            const form = pendingConfirmationForm;
            confirmedForms.add(form);
            closeConfirmation();
            form.requestSubmit();
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && !confirmationModal.hidden) {
                closeConfirmation();
            }
        });
    }
});