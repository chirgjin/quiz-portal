import React, { Component } from 'react';
import 'bootstrap/dist/css/bootstrap.css';
import './../css/dashboard.css';

class Quiz extends Component {
	constructor(props){
		super(props);
		this.state = {
			questions : [],
		}
	}
	componentDidMount(){
		let base_url = 'http://quizportal.cf/backend/get-questions.api.php'
		fetch(base_url,{
			method: 'GET',
			headers: {
				'Accept': 'application/json',
				'Content-Type': 'application/json',
			},
			credentials: 'include'
		})
		.then(res => res.json())
		.then(json => {
			this.setState({
				questions : json,
			});
			console.log(this.state.questions);
		})
		.then(err => err)
	}
	    
	display_ques(ques){
		alert(ques.id)
	}
	radio_submit(ques,e,value){
		let option = value;
		let base_url = 'http://quizportal.cf/backend/submit.api.php'
		let data = {
			ques_id: ques.id,
			answer: option
		}
		fetch(base_url,{
			method:'POST',
			headers: {
				'Accept': 'application/json',
				'Content-Type': 'application/json',
			},
			credentials : 'include',
			body : JSON.stringify(data)			
		})
		.then(res => res.json())
		.then(json => console.log(json))
		.catch(err => err)
	}
	render() {
		if(this.state.questions=== null){
			return (
				<div>SomeThing Went Wrong</div>
			)
		}else{

		return (
			<div>
				<div className="components-wrap row">
					<div className="col-2 question_selector">
						<div className="logo-wrapper">
							<img className="logo" src={require('../img/quizapp.png')} alt=""/>
						</div>
						<div className="question_slider">
							{
								this.state.questions.map((ques) => {
									return(
										<div key={ques.id} onClick={()=> this.display_ques(ques)} className='question'>
											Q{ques.id}
										</div>
									);
								})
							}
						</div>
					</div>
					<div className="col-10 ">
						<div className="questionForm container">
							{
								this.state.questions.map((ques)=>{
									return(
										<div key={ques.id}>
											<div  className="question-box">
												<form>
													<br/><h3>{ques.question}</h3><br/>
													<div className="radio_wrap_l" >
													<input type="radio" onChange={(e)=>this.radio_submit(ques,e,ques.options[0])} className='radio' name="optradio"/><h4>{ques.options[0]}</h4>
													<input type="radio" onChange={(e)=>this.radio_submit(ques,e,ques.options[1])} className='radio' name="optradio"/><h4>{ques.options[1]}</h4>
													</div>
													<div className="radio_wrap_r">
													<input type="radio" onChange={(e)=>this.radio_submit(ques,e,ques.options[2])} className='radio' name="optradio"/><h4>{ques.options[2]}</h4>
													<input type="radio" onChange={(e)=>this.radio_submit(ques,e,ques.options[3])} className='radio' name="optradio"/><h4>{ques.options[3]}</h4>
													</div>												
												</form>
											</div><br/><br/>
										</div>
									)
								})
							}
						</div>						
					</div>
				</div>
			</div>
		);
		}
	}
}

export default Quiz;