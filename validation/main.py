from fastapi import FastAPI
from pydantic import BaseModel
from tasks import run_automation
from fastapi.middleware.cors import CORSMiddleware

app = FastAPI()

origins = [
    "http://localhost",
    "http://localhost:3000",
    "http://192.168.56.1:8007",
    "*",  # SOLO para pruebas
]

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],  # En producción especifica dominios reales
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

class FormRequest(BaseModel):
    url: str
    name: str
    email: str

@app.post("/run-automation")
def start_automation(data: FormRequest):

    task = run_automation.delay(data.dict())

    return {
        "task_id": task.id,
        "status": "processing"
    }

@app.get("/task-status/{task_id}")
def get_status(task_id: str):

    task = run_automation.AsyncResult(task_id)

    return {
        "task_id": task_id,
        "status": task.status,
        "result": task.result if task.ready() else None
    }
