import {Inject, Injectable, LOCALE_ID} from '@angular/core';
import { OrderStatus } from "./order-status.model";

@Injectable({
	providedIn: 'root',
})
export class OrderStatusService {
	private readonly endpoint: string;

	constructor(
		@Inject('BACKEND_URL') backendUrl: string,
		@Inject(LOCALE_ID) private locale: string,
		@Inject('LOCALE_CFG') private localeCFG: {} | any
	) {
		this.endpoint = backendUrl + '/order_status';
	}

	async getOrderStatus(): Promise<OrderStatus[]> {
		const locale = this.localeCFG[this.locale].locale.replace('-', '_');
		const url = `${this.endpoint}?locale=${locale}`;

		const data = await fetch(url, {
			headers: {
				'Content-Type': 'application/json'
			},
		});
		return (await data.json()) ?? [];
	}

}
