import { ApplicationConfig } from '@angular/core';
import { provideRouter } from '@angular/router';

import { routes } from './app.routes';
import { provideAnimationsAsync } from '@angular/platform-browser/animations/async';
import {MatPaginatorIntl} from "@angular/material/paginator";
import {CustomPaginatorIntl} from "../providers/custom-paginator-intl";


export const appConfig: ApplicationConfig = {
  providers: [
	  provideRouter(routes),
	  provideAnimationsAsync(),
	  { provide: MatPaginatorIntl, useClass: CustomPaginatorIntl },
	  { provide: 'BACKEND_URL', useValue: 'http://api.order.management' },
	  {
		  provide: 'LOCALE_CFG',
		  useValue: {
			  'en-US': {
				  locale: 'en-US',
				  currency: 'USD'
			  },
			  'pt': {
				  locale: 'pt-BR',
				  currency: 'BRL'
			  },
		  }
	  }
  ]
};
