import { MatPaginatorIntl } from '@angular/material/paginator';

export class CustomPaginatorIntl extends MatPaginatorIntl {
	override itemsPerPageLabel = $localize`Items per page:`;
	override nextPageLabel = $localize`Next page`;
	override previousPageLabel = $localize`Previous page`;
	override firstPageLabel = $localize`First page`;
	override lastPageLabel = $localize`Last page`;
	override getRangeLabel = (page: number, pageSize: number, length: number) => {
		const of = $localize`of`;
		if (length === 0 || pageSize === 0) {
			return `0 ${of} ${length}`;
		}
		length = Math.max(length, 0);
		const startIndex = page * pageSize;
		const endIndex =
			startIndex < length ? Math.min(startIndex + pageSize, length) : startIndex + pageSize;
		return `${startIndex + 1} – ${endIndex} ${of} ${length}`;
	};
}
