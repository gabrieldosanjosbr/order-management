import {Injectable} from "@angular/core";

@Injectable({providedIn: 'root'})
export class ComponentRegisterService {
	private components = new Map<string, any>();

	registerComponent(name: string, component: any) {
		this.components.set(name, component);
	}

	callComponentFn(componentName: string, functionName: string, args: any[]) {
		const component = this.components.get(componentName);

		if (!component) {
			throw new Error(`Component ${componentName} not found`);
		}

		const fn = component[functionName];

		if (!fn || typeof fn !== 'function') {
			throw new Error(`Function ${functionName} not found in component ${componentName}`);
		}

		return fn.apply(component, args);
	}
}
