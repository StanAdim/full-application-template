export interface ApiResponse {
    code: number,
    data: any,
    message: string
}

export interface StartupData {
    name:string,
    founders: string,
    region: string,
    email: string,
    phone_number: string,
    website: string,
    industry: string,
    dateOfEstablishment: number,
}

export interface BoothData {
    id?: string;  // Optional for creating new booths
    name: string;
    location: string;
    capacity: number;
    description?: string;
}
export interface User {
    id:number,
    firstName: string,
    middleName: string,
    lastName: string,
    email:string,

}

export interface Credential {
    email:string,
    password:string,
}
export interface LoggedUser{
    id:number,
    firstName:string,
    middleName:string,
    lastName:string,
    token:string,
    email:string,
    email_verified_at:string,
    created_at:string,
    updated_at:string,
    message:string
}
export interface RegistrationInfo {
    firstName: string,
    middleName: string,
    lastName: string,
    email: string,
    password: string;
    password_confirmation: string;
}
