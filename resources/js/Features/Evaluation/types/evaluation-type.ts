export interface Evaluation {
    id: string;
    user_id: string;
    submission_id: string;
    createdAt: Date | string;
    updatedAt: Date | string;
}

export interface Message {
    id: string;
    evaluation_id: string;
    sender: MessegeSenderType;
    message: string;
}

export type MessegeSenderType = "assistant" | "user";
