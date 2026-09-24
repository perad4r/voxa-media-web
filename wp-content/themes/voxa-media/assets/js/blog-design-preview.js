(function () {
	const preview = document.querySelector('[data-design-preview]');
	if (!preview) return;

	const search = preview.querySelector('[data-preview-search]');
	const filters = Array.from(preview.querySelectorAll('[data-preview-category]'));
	const cards = Array.from(preview.querySelectorAll('[data-preview-item]'));
	const emptyState = preview.querySelector('[data-preview-no-results]');
	let activeCategory = 'all';

	function updatePreview() {
		const query = (search ? search.value : '').trim().toLocaleLowerCase();
		let visible = 0;

		cards.forEach((card) => {
			const categoryMatches = activeCategory === 'all' || card.dataset.category === activeCategory;
			const textMatches = !query || card.textContent.toLocaleLowerCase().includes(query);
			const shouldShow = categoryMatches && textMatches;
			card.hidden = !shouldShow;
			if (shouldShow) visible += 1;
		});

		if (emptyState) emptyState.hidden = visible > 0;
	}

	filters.forEach((filter) => {
		filter.addEventListener('click', () => {
			activeCategory = filter.dataset.previewCategory;
			filters.forEach((button) => {
				const active = button === filter;
				button.classList.toggle('is-active', active);
				button.setAttribute('aria-pressed', active ? 'true' : 'false');
			});
			updatePreview();
		});
	});

	if (search) {
		search.addEventListener('input', updatePreview);
		search.form.addEventListener('submit', (event) => event.preventDefault());
	}
})();
