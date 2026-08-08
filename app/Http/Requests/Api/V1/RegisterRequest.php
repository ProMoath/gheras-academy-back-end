<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required','string','min:2','max:255'],
            'last_name' => ['required','string','min:2','max:255'],
            'email' => ['required','string','email','max:255','unique:users,email'],
            'country_code' => ['required','string','size:2'],
            'password' => ['required','string','min:6','confirmed'],
            'phone' => ['required','string','max:20','unique:users,phone'],
            'date_of_birth' => ['required','date'],
            'gender' => ['required','in:male,female'],
            'nationality' => ['required','string','max:255'],
            'country_of_residence' => ['required','string','max:255'],
            'telegram_id' => ['required','string','max:255'],
            'education_level' => ['required','string','max:255'],
            'previous_sharia_programs' => ['required','boolean:'],
            'previous_sharia_programs_detail' => ['nullable','string'],
            'how_heard_about' => ['required','string','max:255'],
        ];
    }
    public function messages():array
    {
        return [
            'first_name.required' => 'الاسم الأول مطلوب',
            'first_name.min' => 'الاسم الأول يجب أن يكون حرفين على الأقل',

            'last_name.required' => 'الاسم الأخير مطلوب',
            'last_name.min' => 'الاسم الأخير يجب أن يكون حرفين على الأقل',

            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.email' => 'البريد الإلكتروني غير صحيح',
            'email.unique' => 'البريد الإلكتروني مسجل مسبقاً',

            'phone.required' => 'رقم الهاتف مطلوب',
            'phone.min' => 'رقم الهاتف يجب أن يكون 10 أرقام على الأقل',
            'phone.unique' => 'رقم الهاتف مسجل مسبقاً',

            'country_code.required' => 'كود الدولة مطلوب',
            'country_code.size' => 'كود الدولة يجب أن يكون حرفين (مثل: SA, EG)',

            'password.required' => 'كلمة المرور مطلوبة',
            'password.min' => 'كلمة المرور يجب أن تكون 6 أحرف على الأقل',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابقة',

            'date_of_birth.required' => 'تاريخ الميلاد مطلوب',
            'date_of_birth.date' => 'تاريخ الميلاد يجب أن يكون تاريخاً صحيحاً',

            'gender.required' => 'الجنس مطلوب',
            'gender.in' => 'الجنس يجب أن يكون male أو female',

            'nationality.required' => 'الجنسية مطلوبة',
            'country_of_residence.required' => 'بلد الإقامة مطلوب',

            'telegram_id.required' => 'معرف تيليجرام مطلوب',

            'education_level.required' => 'المستوى التعليمي مطلوب',

            'previous_sharia_programs.required' => 'حقل البرامج الشرعية السابقة مطلوب',
            'previous_sharia_programs.boolean' => 'حقل البرامج الشرعية السابقة يجب أن يكون صحيحاً أو خاطئاً',

            'how_heard_about.required' => 'كيف سمعت عن غراس مطلوب',
        ];
    }
    protected function prepareForValidation(): void
    {
        $this->merge([
            'previous_sharia_programs' => filter_var($this->previous_sharia_programs, FILTER_VALIDATE_BOOLEAN),
        ]);
    }
}
