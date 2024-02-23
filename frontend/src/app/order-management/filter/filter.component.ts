import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';
import {FormsModule} from "@angular/forms";
import {MatButton} from "@angular/material/button";
import {MatFormField, MatLabel} from "@angular/material/form-field";
import {MatInput} from "@angular/material/input";
import {MatOption} from "@angular/material/autocomplete";
import {MatSelect} from "@angular/material/select";
import {CommonModule, NgForOf} from "@angular/common";
import {MatIcon} from "@angular/material/icon";
import {OrderStatusService} from "../../../apis/order-status.service";

@Component({
	selector: 'app-order-filter',
	standalone: true,
	imports: [
		NgForOf,
		CommonModule,
		FormsModule,
		MatFormField,
		MatSelect,
		MatOption,
		MatLabel,
		MatButton,
		MatInput,
		MatIcon,
	],
	templateUrl: './filter.component.html',
	styleUrl: './filter.component.css'
})
export class OrderFilterComponent implements OnInit{
	customerName: any;
	orderStatus: any;
	orderStatusOptions: any;
	@Output() private filterData: EventEmitter<any> = new EventEmitter<any>();

	constructor(private orderStatusService: OrderStatusService) {}

	ngOnInit(): void {
		this.orderStatusService.getOrderStatus().then((ordersStatus) => {
			this.orderStatusOptions = ordersStatus;
		});
	}

	onSubmitFilter() {
		this.filterData.emit({
			customerName: this.customerName,
			orderStatus: this.orderStatus
		});
	}
}
