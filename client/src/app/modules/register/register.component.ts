import { Component } from '@angular/core';
import { NgIf } from '@angular/common';
import { Router } from '@angular/router';
import { ReactiveFormsModule, FormBuilder, FormGroup, Validators } from '@angular/forms';
import { AuthService } from '../../services/auth.service';
import { StorageService } from '../../services/storage.service';

@Component({
  selector: 'app-register',
  standalone: true,
  imports: [ReactiveFormsModule, NgIf],
  templateUrl: './register.component.html',
  styleUrl: './register.component.css'
})
export class RegisterComponent {
  registerForm: FormGroup;
  isRegisterFailed: boolean;
  errorMessage: string;

  constructor(private fb: FormBuilder, private authService: AuthService, private storageService: StorageService, private router: Router) {
    this.registerForm = this.fb.group({
      name: ['', [Validators.required]],
      email: ['', [Validators.required, Validators.email]],
      password: ['', [Validators.required, Validators.minLength(8)]]
    });
    this.isRegisterFailed = false;
    this.errorMessage = '';
  }

  onSubmit(): void {
    const { name, email, password } = this.registerForm.value;

    this.authService.register(name, email, password).subscribe({
      next: data => {
        this.storageService.saveUser(data);
        this.isRegisterFailed = false;
        this.router.navigate(['/account']).then(() => {
          window.location.reload();
        });;
      },
      error: err => {
        this.errorMessage = err.error.error?.name ?? '' + ' ' + err.error.error?.email ?? '';
        this.isRegisterFailed = true;
      }
    });
  }
}
