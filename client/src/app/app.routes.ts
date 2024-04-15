import { Routes } from '@angular/router';
import { HomeComponent } from './modules/home/home.component';
import { DashboardComponent } from './modules/dashboard/dashboard.component';
import { LoginComponent } from './modules/login/login.component';
import { RegisterComponent } from './modules/register/register.component';
import { StocksComponent } from './modules/stocks/stocks.component';

export const routes: Routes = [
  { 
    path: 'home',
    title: 'Home',
    component: HomeComponent,
  },
  { 
    path: 'dashboard',
    title: 'Dashboard',
    component: DashboardComponent,
  },
  { 
    path: 'login',
    title: 'Login',
    component: LoginComponent,
  },
  { 
    path: 'register',
    title: 'Register',
    component: RegisterComponent,
  },
  {
    path: 'stocks/:ticker',
    component: StocksComponent,
  },
];
