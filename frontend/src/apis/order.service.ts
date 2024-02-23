import {Inject, Injectable, LOCALE_ID} from '@angular/core';
import {Order, OrderResponse} from './order.model';

@Injectable({
	providedIn: 'root'
})
export class OrderService {
	private readonly endpoint: string;
	constructor(
		@Inject('BACKEND_URL') backendUrl: string,
		@Inject(LOCALE_ID) private locale: string,
		@Inject('LOCALE_CFG') private localeCFG: {} | any
	) {
		this.endpoint = backendUrl + '/orders';
	}

	async getOrderResponse(params: { [key:string]:any }): Promise<OrderResponse> {
		let url = this.endpoint;
		params['locale'] = this.localeCFG[this.locale].locale.replace('-', '_');

		if (Object.keys(params).length) {
			const queryString = Object.keys(params)
				.filter(key => params[key])
				.map(key => `${encodeURIComponent(key)}=${encodeURIComponent(params[key])}`)
				.join('&');

			url = `${url}?${queryString}`;
		}

		const data = await fetch(url, {
			headers: {
				'Content-Type': 'application/json'
			},
		});

		const orderResponse = (await data.json()) ?? {};

		return this.mapOrders(orderResponse);
	}

	mapOrders(OrderResponse: {totalOrders: 0; orders: Order[]; }): OrderResponse {
		OrderResponse.orders = OrderResponse.orders.map((Order: Order) => ({
			...Order
		}));

		return OrderResponse;
	}

	async cancelOrder(orderId: any) {
		const locale = this.localeCFG[this.locale].locale.replace('-', '_');
		const url = `${this.endpoint}/${orderId}/cancel?locale=${locale}`;

		const data = await fetch(url, {
			headers: {
				'Content-Type': 'application/json'
			},
		});

		return (await data.json()) ?? {};
	}

}
