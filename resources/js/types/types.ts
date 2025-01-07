import { BUSINESS_MODELS, INDUSTRIES } from "@/constants/global";

export type BusinessModel = (typeof BUSINESS_MODELS)[number];
export type Industries = (typeof INDUSTRIES)[number];

export interface SocialLinks {
    platform: string;
    link: string;
}

export interface ProfileData {
    business_name: string;
    business_model: BusinessModel;
    industry: Industries;
    description?: string;
    target_audience?: string;
    unique_selling_point?: string;
    location?: string;
    phone_number?: string;
    website_url?: string;
    social_links?: SocialLinks[];
}
