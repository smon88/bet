from fastapi import FastAPI
from pydantic import BaseModel
from tasks import run_automation

app = FastAPI()

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
