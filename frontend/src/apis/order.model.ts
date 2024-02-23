import {OrderStatus} from "./order-status.model";

export interface Order {
	id: number;
	customer: string,
	address1: string,
	city: string,
	postcode: string,
	country: string,
	amount: string,
	deleted: string,
	date: string,
	lastModified: string,
	orderStatus: OrderStatus,
	cancellable: boolean
}

export interface OrderResponse {
	totalOrders: number
	orders: Order[]
}
