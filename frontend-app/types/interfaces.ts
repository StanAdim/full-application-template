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
    uid:string,
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
    uid:string,
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

export interface Profile {
    id: number
    user: User
    commonField1: string
    commonField2: string
}

export interface StartupProfile implements Profile {
    id: number,
    user: User,
    commonField1: string,
    commonField2: string,
    startupSpecificField1: string
}

export interface HubProfile implements Profile {
    id: number,
    user: User,
    commonField1: string,
    commonField2: string,
    hubSpecificField1: string,
}

export interface AcceleratorProfile implements Profile {
    id: number
    user: User,
    commonField1: string
    commonField2: string
    acceleratorSpecificField1: string
}

export interface Query {
    profiles(type: string): [Profile]
    profile(id: number): Profile
}
