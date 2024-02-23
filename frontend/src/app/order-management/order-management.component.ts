import {
	Component,
	OnInit,
	ViewChild
} from '@angular/core';
import {OrderService} from '../../apis/order.service';
import {Order} from '../../apis/order.model';
import {OrderFilterComponent} from "./filter/filter.component";
import {CommonTableComponent} from "../common/table/table.component";
import {MatSnackBar} from "@angular/material/snack-bar";
import {MatTableDataSource} from "@angular/material/table";
import {ComponentRegisterService} from "../component-register.service";
import {OrderStatus} from "../../apis/order-status.model";

@Component({
	selector: 'app-order-management',
	standalone: true,
	imports: [
		OrderFilterComponent,
		CommonTableComponent
	],
	templateUrl: './order-management.component.html',
	styleUrl: './order-management.component.css'
})
export class OrderManagementComponent implements OnInit {
	dataSource: MatTableDataSource<Order> = new MatTableDataSource<Order>([]);
	totalOrders: number = 0;
	persistentFilters: {} = {};

	@ViewChild(CommonTableComponent) private commonTableComponent: CommonTableComponent | any;

	constructor(
		private orderService: OrderService,
		private _snackBar: MatSnackBar,
		componentRegisterService: ComponentRegisterService
	) {
		componentRegisterService.registerComponent('OrderManagementComponent', this);
	}

	ngOnInit(): void {
		this.fetchOrders({});
	}

	cancelOrder(Order: Order) {
		this.orderService.cancelOrder(Order.id)
			.then((response) => {
				this.openSnackBar(response.message, $localize`Close`);

				if (!response.success) {
					return;
				}

				Order.orderStatus = response.order.orderStatus;
				Order.lastModified = response.order.lastModified;
				Order.cancellable = response.order.cancellable;
			});
	}

	fetchOrders(params: any): void {
		this.orderService.getOrderResponse(params)
			.then((OrderResponse) => {
				this.dataSource = new MatTableDataSource(OrderResponse.orders);
				this.dataSource.sort = this.commonTableComponent.sort;
				this.totalOrders = OrderResponse.totalOrders;
			});
	}

	onSubmitFilter(event: any) {
		event.pageIndex = 0;
		this.commonTableComponent.paginator.pageIndex = 0
		this.fetchOrders(Object.assign(this.persistentFilters, event));
	}

	openSnackBar(message: string, action: string) {
		this._snackBar.open(message, action);
	}

	displayedColumns() {
		return {
			id: $localize`ID`,
			customer: $localize`Customer`,
			amount: {
				label: $localize`Amount`,
				format: function(value: number, locale: any) {
					return new Intl.NumberFormat(locale.locale, {
						style: 'currency',
						currency: locale.currency
					}).format(value);
				},
			},
			date: {
				label: $localize`Buy Date`,
				format: function (value:string, locale:any) {
					let options: Intl.DateTimeFormatOptions = {
						year: 'numeric',
						month: 'numeric',
						day: 'numeric',
						hour: 'numeric',
						minute: 'numeric'
					};
					return (new Intl.DateTimeFormat(locale.locale, options).format(new Date(value)))
						.replace(',', ' -');
				}
			},
			lastModified: {
				label: $localize`Last Modified`,
				format: function (value:string, locale:any) {
					let options: Intl.DateTimeFormatOptions = {
						year: 'numeric',
						month: 'numeric',
						day: 'numeric',
						hour: 'numeric',
						minute: 'numeric'
					};
					return (new Intl.DateTimeFormat(locale.locale, options).format(new Date(value)))
						.replace(',', ' -');
				}
			},
			deleted: $localize`Deleted`,
			address1: $localize`Address`,
			postcode: $localize`Postcode`,
			city: $localize`City`,
			country: $localize`Country`,
			orderStatus: {
				label: $localize`Order Status`,
				format: function (OrderStatus: OrderStatus) {
					return OrderStatus.name;
				}
			},
			actions: {
				label: $localize`Actions`,
				component: 'OrderManagementComponent',
				buttons: {
					matMiniFabType: {
						cancelOrder: {
							color: 'warn',
							icon: 'block',
							isVisibleButton: function (Order: Order) {
								return Order.cancellable;
							}
						}
					}
				}
			}
		};
	}

	onPaginatorChange(event: any) {
		this.fetchOrders(Object.assign(this.persistentFilters, event));
	}
}
