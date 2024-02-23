import {
	Component,
	EventEmitter, Inject,
	Input, LOCALE_ID,
	Output,
	ViewChild
} from '@angular/core';
import {
	MatCell,
	MatCellDef,
	MatColumnDef,
	MatHeaderCell,
	MatHeaderCellDef,
	MatHeaderRow,
	MatHeaderRowDef,
	MatRow,
	MatRowDef,
	MatTable,
	MatTableDataSource,
	MatTableModule
} from "@angular/material/table";
import {MatSort, MatSortModule} from "@angular/material/sort";
import {NgForOf, NgIf, NgSwitch, NgSwitchCase, NgTemplateOutlet} from "@angular/common";
import {MatIcon} from "@angular/material/icon";
import {MatButton, MatMiniFabButton} from "@angular/material/button";
import {MatPaginator} from "@angular/material/paginator";
import {MatFormField, MatInput, MatLabel} from "@angular/material/input";
import {MatOption} from "@angular/material/autocomplete";
import {MatSelect} from "@angular/material/select";
import {ReactiveFormsModule} from "@angular/forms";
import {ComponentRegisterService} from "../../component-register.service";

@Component({
	selector: 'app-common-table',
	standalone: true,
	imports: [
		MatTable,
		MatHeaderRow,
		MatHeaderRowDef,
		MatRowDef,
		MatRow,
		MatSort,
		MatColumnDef,
		MatHeaderCell,
		MatCell,
		MatCellDef,
		NgForOf,
		MatHeaderCellDef,
		MatTableModule,
		MatSortModule,
		MatIcon,
		MatMiniFabButton,
		NgIf,
		MatPaginator,
		NgTemplateOutlet,
		MatInput,
		MatOption,
		MatSelect,
		NgSwitchCase,
		ReactiveFormsModule,
		MatFormField,
		MatLabel,
		MatButton,
		NgSwitch,
	],
	templateUrl: './table.component.html',
	styleUrl: './table.component.css'
})
export class CommonTableComponent {
	@Input() paginatorLength: number = 10;
	@Input() dataSource: MatTableDataSource<any> | any;
	@Input() displayedColumns: {
		[key:string]:any,
		actions: {
			component: string,
			buttons:{[key:string]:any}
		}
	} | any;
	@Input() actions: string[] = [];
	@Output() private onPaginatorChange: EventEmitter<any> = new EventEmitter<any>();

	@ViewChild(MatSort) sort: MatSort | any;
	@ViewChild(MatPaginator) paginator: MatPaginator | any;

	constructor(
		private componentRegisterService: ComponentRegisterService,
		@Inject(LOCALE_ID) private locale: string,
		@Inject('LOCALE_CFG') private localeCFG: {} | any) {
	}

	onPageChange(event: { pageIndex: any; pageSize: any; }): void {
		this.onPaginatorChange.emit(event)
	}

	getColumns(): string[] {
		return Object.keys(this.displayedColumns);
	}

	getButtonTypes(): string[] {
		return Object.keys(this.displayedColumns.actions.buttons);
	}

	getActions(buttonType: string) {
		return Object.keys(this.displayedColumns.actions.buttons[buttonType]);
	}

	getHeaderCell(col: string) : string {
		let label = this.displayedColumns[col];

		if (label instanceof Object) {
			return label.label;
		}

		return label;
	}

	getCellValue(col: string, element: any):any {
		let column = this.displayedColumns[col];

		if (column instanceof Object && typeof column.format !== "undefined") {
			return column.format(element[col], this.localeCFG[this.locale]);
		}

		return element[col];
	}

	isVisibleButton(button:string, buttonType: string, element: any): boolean {
		return this.displayedColumns.actions.buttons[buttonType][button].isVisibleButton(element);
	}

	doAction(action: string, item: any): void {
		this.componentRegisterService.callComponentFn(
			this.displayedColumns.actions.component,
			action,
			[item]
		);
	}

	getColor(button: string, buttonType: string): string {
		return this.displayedColumns.actions.buttons[buttonType][button].color;
	}

	getIcon(button: string, buttonType: string) {
		return this.displayedColumns.actions.buttons[buttonType][button].icon;
	}
}
