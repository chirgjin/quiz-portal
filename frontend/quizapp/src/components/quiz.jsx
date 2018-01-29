import React, { Component } from 'react';
import 'bootstrap/dist/css/bootstrap.css';
import './../css/dashboard.css';

class Quiz extends Component {
	constructor(props){
		super(props);
		this.state = {
			questions : [],
			response: JSON.parse(localStorage.getItem('response')),
			credential1: localStorage.getItem('credential1'),
			credential2:localStorage.getItem('credential2')
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
		}).then(res => res.json())
		.then((json) => {
			if(!json.data)
				json.data = [];
			this.setState({questions : json.data});
		})
		.catch(err => console.log(err))
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
		console.log(this.state.credential1);
		console.log(this.state.credential2);
		console.log(this.state.response);
		console.log(this.state.questions);
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
							<strong>Welcome!</strong>
							<div className='question'>{this.state.credential1}</div>
							<div className='question'>{this.state.credential2}</div>
						</div>
					</div>
					<div className="col-10 ">
						<div className="questionForm container">
							<h2>Start Quiz</h2>
							<div className="row" >
								{
									this.state.questions.map((ques)=>{
										return(
											<div className="col-md-4 question-box" key={ques.id}>
												<div className="cards" >
													<form>
														
														<strong>{ques.question}</strong><br/>
															<div className="center_text" ><label><span><input type="radio" onChange={(e)=>this.radio_submit(ques,e,ques.options[0])} className='radio' name="optradio"/></span><span>{ques.options[0]}</span></label>
															<label><span><input type="radio" onChange={(e)=>this.radio_submit(ques,e,ques.options[1])} className='radio' name="optradio"/></span><span>{ques.options[1]}</span></label></div>
															<div className="center_text" ><label><span><input type="radio" onChange={(e)=>this.radio_submit(ques,e,ques.options[2])} className='radio' name="optradio"/></span><span>{ques.options[2]}</span></label>
															<label><span><input type="radio" onChange={(e)=>this.radio_submit(ques,e,ques.options[3])} className='radio' name="optradio"/></span><span>{ques.options[3]}</span></label></div>											
														
													</form>
												</div>
											</div>
										)
									})
								}
							</div>
						</div>						
					</div>
				</div>
			</div>
		);
		}
	}
}

export default Quiz;