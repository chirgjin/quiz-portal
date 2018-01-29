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
			credential2:localStorage.getItem('credential2'),
			min:0,
			sec:0
		}
	}
	componentWillMount(){
		this.timer(this.state.response.ending_time,this.state.response.starting_time )
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
		// setInterval(() =>this.timer(this.state.response.ending_time,this.state.response.starting_time ), 1000)
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

	timer(end, start){
		let time =  end - start;
		console.log(time);
		let min = Math.floor(time / 60);
		let sec = Math.floor(time%60)
		console.log("min",min,"sec",sec);
		this.setState({min, sec})
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
						<div className="count_down">
							<div className='question'>{this.state.min}:{this.state.sec}</div>
						</div>
					</div>
					<div className="col-10 ">
						<div className="questionForm container">
							<h2 className="start_quiz">START QUIZ</h2>
							<div className="row" >
								{
									this.state.questions.map((ques)=>{
										return(
											<div className="col-md-4 question-box" key={ques.id}>
												<div className="cards" >
													<form>
														
														<strong className="letter-space">{ques.question}</strong><br/>
															<div className="center_text" ><label><span><input type="radio" onChange={(e)=>this.radio_submit(ques,e,ques.options[0])} className='radio' name="optradio"/></span><span className="letter-space" >{ques.options[0]}</span></label>
															<label><span><input type="radio" onChange={(e)=>this.radio_submit(ques,e,ques.options[1])} className='radio' name="optradio"/></span><span className="letter-space" >{ques.options[1]}</span></label></div>
															<div className="center_text" ><label><span><input type="radio" onChange={(e)=>this.radio_submit(ques,e,ques.options[2])} className='radio' name="optradio"/></span><span className="letter-space" >{ques.options[2]}</span></label>
															<label><span><input type="radio" onChange={(e)=>this.radio_submit(ques,e,ques.options[3])} className='radio' name="optradio"/></span><span className="letter-space" >{ques.options[3]}</span></label></div>											
														
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